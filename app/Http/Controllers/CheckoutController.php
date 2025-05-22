<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderModifier;
use App\Models\OrderHampersItem;
use App\Models\OrderDelivery;
use App\Models\OrderPayment;
use App\Services\CartService;
use App\Services\BuyNowService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function mokaStockAdjustment($payload)
    {
        $baseUrl = env('MOKA_API_URL');
        $outletId = env('MOKA_OUTLET_ID');
        $token = getMokaToken();

        $response = Http::withToken($token)
            ->post($baseUrl . '/v1/outlets/' . $outletId . '/adjustment/items', $payload);

        if ($response->successful()) {
            Log::info('Adjust MOKA Item successfully.');
            return true;
        } else {
            $status = $response->status();

            // If token expired, refresh it and retry
            if ($status === 401) {
                $newToken = refreshMokaToken();
                if ($newToken) {
                    Log::info('Token refreshed. Retrying Adjust MOKA Item...');
                    return $this->mokaStockAdjustment($payload); // Retry
                }
            } else {
                Log::error('Adjust MOKA Item API failed', [
                    'status' => $status,
                    'body' => $response->body(),
                    'payload' => $payload
                ]);
                insertApiErrorLog('Adjust MOKA Item', "{$baseUrl}/v1/outlets/outlet_id/adjustment/items", 'POST', null, null, json_encode($payload), $status, $response->body());
                return false;
            }
        }
    }

    public function calculateShipping(Request $request)
    {
        $baseUrl = config('app.komerce_api_url');
        $apiKey = config('app.komerce_api_key');
        $shipperRegionId = config('app.shipper_region_id');
        $shipperLatLng = config('app.shipper_lat_lng');

        $response = Http::withHeaders([
            'x-api-key' => $apiKey
        ])->get("{$baseUrl}/tariff/api/v1/calculate", [
            'shipper_destination_id' => $shipperRegionId,
            'receiver_destination_id' => $request->receiver_destination_id,
            'origin_pin_point' => $shipperLatLng,
            'destination_pin_point' => $request->destination_pin_point,
            'weight' => $request->weight,
            'item_value' => $request->item_value,
            'cod' => 'no'
        ]);

        return $response->json();
    }

    public function viewSuccess($invoiceNo) {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $order = Order::with([
                'details.product',
                'delivery.address'  // eager load nested relation
            ])->where('invoice_number', $invoiceNo)
            ->where('orders.status', 'waiting for payment')
            ->first();
            $totalVariantsNeeded = [];
            $roOrderDetails = [];
            $mokaDetails = [];

            if ($order) {
                $orderDelivery = $order->delivery;
                // Step 1: Collect stock
                foreach ($order->details as $item) {
                    //count needed qty for moka deduction
                    $key = $item->product_variant_id;
                    if (!isset($totalVariantsNeeded[$key])) {
                        $totalVariantsNeeded[$key] = 0;
                    }
                    $totalVariantsNeeded[$key] += $item->quantity;

                    if ($item->type === 'hampers') {
                        // Get hamper items and deduct their variant stock
                        $hamperItems = OrderHampersItem::where('order_detail_id', $item->id)->get();
                        foreach ($hamperItems as $hamperItem) {
                            //count needed qty for moka deduction
                            $key = $hamperItem->product_variant_id;
                            if (!isset($totalVariantsNeeded[$key])) {
                                $totalVariantsNeeded[$key] = 0;
                            }
                            $totalVariantsNeeded[$key] += $hamperItem->quantity;
                        }
                    }

                    // store to order details for raja ongkir store order
                    $productQty = intval($item->quantity);
                    $productTotalPrice = intval($item->total_price); //include modifiers if exist
                    $productPrice = $productTotalPrice / $productQty;
                    $roOrderDetails[] = [
                        "product_name" => $item->product_name,
                        "product_variant_name" => $item->product_variant_name ?? '',
                        "product_price" => $productPrice,
                        "product_width" => intval($item?->product->width) ?? 1,
                        "product_height" => intval($item?->product->height) ?? 1,
                        "product_weight" => isset($item?->product->weight) ? intval($item?->product->weight) * 1000 : 1000,
                        "product_length" => intval($item?->product->length) ?? 1,
                        "qty" => $productQty,
                        "subtotal" => $productTotalPrice
                    ];
                }

                // Step 2: update MOKA stock
                // Step 2.1: Validate total stock
                foreach ($totalVariantsNeeded as $variantId => $neededQty) {
                    $variant = ProductVariant::with('product')->find($variantId);
                    $productName = $variant->name
                        ? "{$variant->product->name} - {$variant->name}"
                        : $variant->product->name;
                    if (!$variant || $variant->stock < $neededQty) {
                        throw new \Exception('(1): Product ' . $productName . ' only has ' . $variant->stock . ' left.');
                    }
                }

                // Deduct stock after validation passed
                foreach ($totalVariantsNeeded as $variantId => $neededQty) {
                    $variant = ProductVariant::find($variantId);
                    $variant->stock -= $neededQty;
                    $variant->updated_by = $user->id;
                    $variant->save();

                    //prepare moka data
                    if ($variant->track_stock == 1) {
                        $mokaDetails[$variantId] = [
                            'variant' => $variant
                        ];
                    }
                }

                $historyDetails = [];
                foreach ($mokaDetails as $entry) {
                    $variant = $entry['variant'];
                    $remainingStock = $variant->stock;

                    $historyDetails[] = [
                        'item_id' => $variant->product->moka_id_product,
                        'item_variant_id' => $variant->moka_id_product_variant,
                        'actual_stock' => $remainingStock
                    ];
                }

                if (count($historyDetails) > 0) {
                    $payload = [
                        'adjustment' => [
                            'note' => "ecomm:{$order->id}:{$invoiceNo}",
                            'history_details' => $historyDetails
                        ]
                    ];

                    $result = $this->mokaStockAdjustment($payload);
                    if (!$result) {
                        throw new \Exception('(2): Terjadi kesalahan saat proses integrasi stock. Harap hubungi admin.');
                    }
                } else {
                    throw new \Exception('(3): Terjadi kesalahan saat proses integrasi stock. Tidak ada data yang dikirim ke moka.');
                }

                // Step 3: Store order delivery to raja ongkir
                $komercePayload = [
                    "order_date" => $orderDelivery?->date,
                    "brand_name" => env('SHIPPER_BRAND_NAME'),
                    "shipper_name" => env('SHIPPER_NAME'),
                    "shipper_phone" => env('SHIPPER_PHONE'),
                    "shipper_destination_id" => intval(env('SHIPPER_REGION_ID')),
                    "shipper_address" => env('SHIPPER_ADDRESS'),
                    "origin_pin_point" => env('SHIPPER_LAT_LNG'),
                    "shipper_email" => env('SHIPPER_EMAIL'),
                    "receiver_name" => $user->name,
                    "receiver_phone" => normalizePhone($user->phone),
                    "receiver_destination_id" => intval($orderDelivery?->address?->region_id),
                    "receiver_address" => $orderDelivery?->address?->address,
                    "destination_pin_point" => $orderDelivery?->address?->latitude . ',' . $orderDelivery?->address?->longitude,
                    "shipping" => $orderDelivery?->shipping_name,
                    "shipping_type" => $orderDelivery?->shipping_type,
                    "payment_method" => "BANK TRANSFER",
                    "shipping_cost" => intval($orderDelivery?->shipping_cost),
                    "shipping_cashback" =>intval($orderDelivery?->shipping_cashback),
                    "service_fee" => intval($orderDelivery?->service_fee),
                    "additional_cost" => 0,
                    "grand_total" => intval($orderDelivery?->grand_total),
                    "cod_value" => intval($orderDelivery?->grand_total),
                    "insurance_value" => 0,
                    "order_details" => $roOrderDetails
                ];
                $baseUrlKomerce = config('app.komerce_api_url');
                $komerceApiKey = config('app.komerce_api_key');

                // Step 3.1: Send order to Komerce
                $komerceResponse = Http::withHeaders([
                    'x-api-key' => $komerceApiKey
                ])->post("{$baseUrlKomerce}/order/api/v1/orders/store", $komercePayload);

                if (!$komerceResponse->successful() || $komerceResponse['meta']['code'] !== 201) {
                    throw new \Exception('(4): Failed to create Komerce order: ' . $komerceResponse['meta']['message']);
                }
                $komerceData = $komerceResponse['data'];

                // Step 3.2: Update order delivery data and status
                OrderDelivery::where('id', $orderDelivery->id)
                ->update([
                    'order_delivery_id' => $komerceData['order_id'],
                    'order_delivery_no' => $komerceData['order_no'],
                    'status' => 'submitted',
                    'updated_by' => $user->id,
                ]);

                // Step 4: Update order status
                Order::where('id', $order->id)
                ->update([
                    'status' => 'pending',
                    'updated_by' => $user->id,
                ]);

                // Step 5: Update order payment status
                OrderPayment::where('order_id', $order->id)
                ->update([
                    'status' => 'PAID',
                    'updated_by' => $user->id,
                ]);

                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error payment invoice no (view success): ' . $invoiceNo . ', ' . $e->getMessage());
        }

        return view('lagramma-co-success', compact('invoiceNo'));
    }

    public function viewFailed($invoiceNo) {
        $user = auth()->user();

        DB::beginTransaction();
        try {
            $order = Order::where('invoice_number', $invoiceNo)
                ->where('status', 'waiting for payment')
                ->first();

            if ($order) {
                // Update order status
                Order::where('id', $order->id)
                ->update([
                    'status' => 'payment failed',
                    'updated_by' => $user->id,
                ]);

                // Update order payment status
                OrderPayment::where('order_id', $order->id)
                ->update([
                    'status' => 'FAILED',
                    'updated_by' => $user->id,
                ]);

                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error payment invoice no (view failed): ' . $invoiceNo . ', ' . $e->getMessage());
        }

        return view('lagramma-co-failed', compact('invoiceNo'));
    }
}

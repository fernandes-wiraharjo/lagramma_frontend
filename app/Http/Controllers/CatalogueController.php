<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderModifier;
use App\Models\OrderHampersItem;
use App\Models\OrderDelivery;
use App\Models\OrderDeliveryDetail;
use App\Models\OrderPayment;
use App\Services\CartService;
use App\Services\BuyNowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Exception\ApiException;

class CatalogueController extends Controller
{
    public function index(Request $request) {
        // $today = Carbon::today();
        $categories = Category::where('is_active', true)->get();
        $products = Product::with('category', 'mainImage')
            ->where('is_active', true)
            ->whereDoesntHave('deactivateDates', function ($query) {
                $query->where('start_date', '<=', now())
                      ->where('end_date', '>=', now());
            })
            ->orderBy('name', 'asc')
            ->get();
        $productsArray = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'wishList' => false,
                'productImg' => $product->mainImage?->image_path
                    ? asset(config('app.backend_url') . '/storage/' . $product->mainImage->image_path)
                    : asset('images/no_image.jpg'),
                'productTitle' => $product->name,
                'category' => $product->category->name ?? 'Uncategorized',
                'price' => '0.00',
                'discount' => '0%',
                'rating' => '0.0',
                'arrival' => false,
                'color' => false,
            ];
        })->toArray();

        return view('catalogue', compact('categories', 'products', 'productsArray'));
    }

    public function getByID($id) {
        $product = Product::with([
            'images',
            'mainImage',
            'variants',
            'category',
            'modifiers.modifier' => function($query) {
                $query->where('is_active', true); // Only active modifiers
            },
            'modifiers.modifier.options' => function($query) {
                $query->where('is_active', true); // Only active modifier options
            }
        ])
        ->where('id', $id)
        ->first();

        // Log::info($product);

        return view('product-detail', compact('product'));
    }

    public function addToCart(Request $request, CartService $cartService) {
       if ($request->is_hampers) {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'variant_id' => 'required|exists:product_variants,id',
                'hamper_stock' => 'required|integer|min:1',
                'hamper_items' => 'required|array',
                'quantity' => 'required|integer|min:1'
            ]);

            $hamperStock = $validated['hamper_stock'];
            $hamperItems = $validated['hamper_items'];
            $quantity = $validated['quantity'];

            if ($hamperStock < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$hamperStock} hampers available.",
                ]);
            }

            $items = [];
            foreach ($hamperItems as $itemId => $itemQty) {
                $item = ProductVariant::with('product')->find($itemId);
                $displayName = $item->name
                    ? "{$item->product->name} - {$item->name}"
                    : $item->product->name;

                if (!$item || $item->stock < ($itemQty * $quantity)) {
                    return response()->json([
                        'success' => false,
                        'message' => "Item '{$displayName}' does not have enough stock.",
                    ]);
                }

                $items[] = [
                    'product_id' => $item->product->id,
                    'product_name' => $item->product->name,
                    'id' => $itemId, //variant id
                    'name' => $item->name, //variant name
                    'quantity' => (int) $itemQty,
                ];
            }
        } else {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'variant_id' => 'required|exists:product_variants,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $variant = ProductVariant::find($validated['variant_id']);

            if ($variant->stock < $validated['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$variant->stock} items available for this variant.",
                ]);
            }
        }

        $totalWeight = $request->weight * $request->quantity;

        //logic add to cart
        $cartService->addItem([
            'product_id' => $request->product_id,
            'product_variant_id' => $request->variant_id,
            'product_name' => $request->product_name,
            'product_variant_name' => $request->variant_name,
            'type' => $request->type, // 'hampers' or 'product'
            'image' => $request->main_image,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'modifiers' => $request->modifiers ?? [],
            'weight' => $request->weight,
            'total_weight' => $totalWeight,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
            'items' => $items ?? [] // only for hampers
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product successfully added to cart!',
        ]);
    }

    public function updateCartQuantity(Request $request, CartService $cartService)
    {
        try {
            $key = $request->key;
            $change = (int) $request->change;

            $cartService->updateItemQuantity($key, $change);

            $cart = session('shopping_cart', []);
            $subtotal = collect($cart)->sum('total_price');
            return response()->json(['success' => true, 'subtotal' => $subtotal]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update cart quantity. ' . $e->getMessage() . '. Page will be reloaded for data consistency']);
        }
    }

    public function removeCartItem(Request $request, CartService $cartService)
    {
        try {
            $key = $request->key;
            $cartService->removeItem($key);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to remove cart item. ' . $e->getMessage()]);
        }
    }

    public function viewCart(Request $request) {
        return view('lagramma-cart');
    }

    public function clearCart(CartService $cartService)
    {
        try {
            $cartService->clearCart();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to clear cart. ' . $e->getMessage()]);
        }
    }

    public function validateCartBeforeCheckout(Request $request)
    {
        $cart = session('shopping_cart', []);

        foreach ($cart as $item) {
            $variant = ProductVariant::find($item['product_variant_id']);
            $productName = $item['product_variant_name']
                ? "{$item['product_name']} - {$item['product_variant_name']}"
                : $item['product_name'];

            if (!$variant || $variant->stock < $item['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => "Product '{$productName}' only has {$variant->stock} left.",
                ]);
            }

            // Hampers (has multiple items inside)
            if ($item['type'] === 'hampers') {
                foreach ($item['items'] as $hamperItem) {
                    $variant = ProductVariant::find($hamperItem['id']);
                    $neededQty = $hamperItem['quantity'] * $item['quantity'];
                    $itemName = $hamperItem['name']
                        ? "{$hamperItem['product_name']} - {$hamperItem['name']}"
                        : $hamperItem['product_name'];

                    if (!$variant || $variant->stock < $neededQty) {
                        return response()->json([
                            'success' => false,
                            'message' => "Item '{$itemName}' in '{$productName}' only has {$variant->stock} left.",
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Stock is sufficient for all items.',
            'redirect_url' => route('checkout.page') // or any route
        ]);
    }

    public function buyNow(Request $request, BuyNowService $buyNowService) {
        if ($request->is_hampers) {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'variant_id' => 'required|exists:product_variants,id',
                'hamper_stock' => 'required|integer|min:1',
                'hamper_items' => 'required|array',
                'quantity' => 'required|integer|min:1'
            ]);

            $hamperStock = $validated['hamper_stock'];
            $hamperItems = $validated['hamper_items'];
            $quantity = $validated['quantity'];

            if ($hamperStock < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$hamperStock} hampers available.",
                ]);
            }

            $items = [];
            foreach ($hamperItems as $itemId => $itemQty) {
                $item = ProductVariant::with('product')->find($itemId);
                $displayName = $item->name
                    ? "{$item->product->name} - {$item->name}"
                    : $item->product->name;

                if (!$item || $item->stock < ($itemQty * $quantity)) {
                    return response()->json([
                        'success' => false,
                        'message' => "Item '{$displayName}' does not have enough stock.",
                    ]);
                }

                $items[] = [
                    'product_id' => $item->product->id,
                    'product_name' => $item->product->name,
                    'id' => $itemId, //variant id
                    'name' => $item->name, //variant name
                    'quantity' => (int) $itemQty,
                ];
            }
        } else {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'variant_id' => 'required|exists:product_variants,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $variant = ProductVariant::find($validated['variant_id']);

            if ($variant->stock < $validated['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$variant->stock} items available for this variant.",
                ]);
            }
        }

        $totalWeight = $request->weight * $request->quantity;

        //logic add to cart
        $buyNowService->addItem([
            'product_id' => $request->product_id,
            'product_variant_id' => $request->variant_id,
            'product_name' => $request->product_name,
            'product_variant_name' => $request->variant_name,
            'type' => $request->type, // 'hampers' or 'product'
            'image' => $request->main_image,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'modifiers' => $request->modifiers ?? [],
            'weight' => $request->weight,
            'total_weight' => $totalWeight,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
            'items' => $items ?? [] // only for hampers
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Proceed to checkout!',
        ]);
    }

    public function viewCheckout(Request $request) {
        if (!Auth::check()) {
            return redirect()->route('index');
        }

        $source = $request->query('source');
        if ($source === 'buy_now' && session()->has('buy_now')) {
            $checkoutData = session('buy_now');
            $checkoutSource = 'buy_now';
        } else {
            $checkoutData = session('shopping_cart');
            $checkoutSource = 'cart';
        }

        return view('lagramma-checkout', [
            'checkoutData' => $checkoutData,
            'checkoutSource' => $checkoutSource,
        ]);
    }

    public function generateInvoiceNumber()
    {
        return 'INV-' . date('YmdHis') . '-' . strtoupper(uniqid());
    }

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

    public function createOrder(Request $request)
    {
        $source = $request->input('source');

        if ($source === 'buy_now' && session()->has('buy_now')) {
            $checkoutItems = session('buy_now');
        } elseif ($source === 'cart' && session()->has('shopping_cart')) {
            $checkoutItems = session('shopping_cart');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No items available to create order.'
            ]);
        }

        DB::beginTransaction();
        try {
            // Init variables
            $user = auth()->user();
            $sendToOther = $request->input('is_send_to_other', false);
            $stoPicName = $sendToOther ? $request->input('sto_pic_name') : '';
            $stoPicPhone = $sendToOther ? $request->input('sto_pic_phone') : '';
            $stoReceiverName = $sendToOther ? $request->input('sto_receiver_name') : '';
            $stoReceiverPhone = $sendToOther ? $request->input('sto_receiver_phone') : '';
            $stoNote = $sendToOther ? $request->input('sto_note') : '';
            $invoiceNo = $this->generateInvoiceNumber();
            $grandTotal = $request->input('grand_total');
            $subtotal = collect($checkoutItems)->sum('total_price');
            $orderQuantity = collect($checkoutItems)->sum('quantity');

            foreach ($checkoutItems as $item) {
                //store to order details for raja ongkir store order
                $productPrice = $item['price'] + collect($item['modifiers'])->sum('price');
            }

            // Step 3: Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'invoice_number' => $invoiceNo,
                'order_quantity' => $orderQuantity,
                'status' => 'waiting for payment',
                'order_price' => $grandTotal,
                'created_by' => auth()->id(),
                'updated_at' => null
            ]);

            // Step 3.1: Create order detail, hampers, modifiers
            foreach ($checkoutItems as $item) {
                // Initialize base price and modifiers total
                $baseTotalPrice = $item['price'] * $item['quantity'];
                $modifiersTotalPrice = 0;

                // If modifiers exist, calculate their total price
                if (isset($item['modifiers']) && is_array($item['modifiers']) && count($item['modifiers']) > 0) {
                    foreach ($item['modifiers'] as $modifier) {
                        // Assuming each modifier has a 'price' and the quantity can be set
                        $modifiersTotalPrice += $modifier['price'] * $item['quantity'];
                    }
                }

                // Final total price: base price + modifiers price
                $totalPrice = $baseTotalPrice + $modifiersTotalPrice;

                $orderDetail = OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['product_variant_id'],
                    'type' => $item['type'],
                    'product_name' => $item['product_name'],
                    'product_variant_name' => $item['product_variant_name'] ?? '',
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total_price' => $totalPrice,
                    'created_by' => auth()->id(),
                    'updated_at' => null
                ]);

                // If hampers
                if ($item['type'] === 'hampers') {
                    foreach ($item['items'] as $hamperItem) {
                        OrderHampersItem::create([
                            'order_detail_id' => $orderDetail->id,
                            'product_id' => $hamperItem['product_id'],
                            'product_variant_id' => $hamperItem['id'],
                            'product_name' => $hamperItem['product_name'],
                            'product_variant_name' => $hamperItem['name'] ?? '',
                            'quantity' => $hamperItem['quantity'] * $item['quantity'],
                            'created_by' => auth()->id(),
                            'updated_at' => null
                        ]);
                    }
                }

                // If modifiers exist
                if (isset($item['modifiers']) && is_array($item['modifiers']) && count($item['modifiers']) > 0) {
                    foreach ($item['modifiers'] as $modifier) {
                        OrderModifier::create([
                            'order_detail_id' => $orderDetail->id,
                            'modifier_id' => $modifier['modifier_id'],
                            'modifier_option_id' => $modifier['modifier_option_id'],
                            'modifier_name' => $modifier['modifier_name'],
                            'modifier_option_name' => $modifier['modifier_option_name'],
                            'created_by' => auth()->id(),
                            'updated_at' => null
                        ]);
                    }
                }
            }

            // Step 4: Create Invoice
            Configuration::setXenditKey(config('services.xendit.secret'));
            $apiInstance = new InvoiceApi();
            $create_invoice_request = new CreateInvoiceRequest([
                'external_id' => $invoiceNo,
                'amount' => $grandTotal,
                'payer_email' => $user->email,
                'description' => 'Invoice La Gramma ' . $invoiceNo,
                'success_redirect_url' => route('payment.success', ['invoiceNo' => $invoiceNo]),
                'failed_redirect_url' => route('payment.failed', ['invoiceNo' => $invoiceNo]),
            ]);
           $invoice = $apiInstance->createInvoice($create_invoice_request);

            //  Step 4.1: Insert Order Payment
            OrderPayment::create([
                'order_id' => $order->id,
                'vendor_invoice_id' => $invoice['id'],
                'transaction_date' => now(),
                'status' => 'PENDING',
                'invoice_url' => $invoice['invoice_url'],
                'expiry_date' => Carbon::parse($invoice['expiry_date'])->setTimezone('Asia/Jakarta'),
                'created_by' => $user->id,
                'updated_at' => null
            ]);

            // Step 5: Save order delivery and detail
            // Step 5.1: Save to order_deliveries
            $orderDelivery = OrderDelivery::create([
                'order_id' => $order->id,
                'address_id' => $request->input('receiver_address_id'),
                // 'date' => now()->format('Y-m-d H:i:s'),
                'shipping_name' => $request->input('shipping'),
                'shipping_type' => $request->input('shipping_type'),
                'shipping_cost' => $request->input('shipping_cost'),
                'shipping_cashback' => $request->input('shipping_cashback'),
                'service_fee' => $request->input('service_fee'),
                'grand_total' => $grandTotal,
                'is_send_to_other' => $sendToOther,
                'sto_pic_name' => $stoPicName,
                'sto_pic_phone' => $stoPicPhone,
                'sto_receiver_name' => $stoReceiverName,
                'sto_receiver_phone' => $stoReceiverPhone,
                'sto_note' => $stoNote,
                'status' => 'not submitted',
                'created_by' => $user->id,
                'updated_at' => null,
            ]);

            // Step 6: Clear session
            if ($source === 'buy_now') {
                session()->forget('buy_now');
            } else {
                session()->forget('shopping_cart');
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'redirect_url' => $invoice['invoice_url'] // or any route
            ]);
        } catch (ApiException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order. ' . $e->getMessage()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order. ' . $e->getMessage()
            ]);
        }
    }
}

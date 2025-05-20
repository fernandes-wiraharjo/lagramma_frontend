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
use App\Services\CartService;
use App\Services\BuyNowService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
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
        //got order from invoice no, join to order details, order details have product variantid,
        //then got variant id to process below query, quantity got from order details table
        $variant = ProductVariant::find($id);
        if ($variant) {
            $variant->stock -= $item['quantity'];
            $variant->updated_by = auth()->id();
            $variant->save();
        }
        //in order detail also has type as product and hampers, if hampers then get hampers item data in order hampers items table,
        //then got variant id to process above query, quantity got from order hampers items table

        return view('lagramma-co-success', compact('invoiceNo'));
    }

    public function viewFailed($invoiceNo) {
        return view('lagramma-co-failed', compact('invoiceNo'));
    }
}

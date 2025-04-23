<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;

class CatalogueController extends Controller
{
    public function index(Request $request) {
        $today = Carbon::today();
        $categories = Category::where('is_active', true)->get();
        $products = Product::with('category', 'mainImage')
            ->where('is_active', true)
            ->whereDoesntHave('deactivateDates', function ($query) use ($today) {
                $query->whereDate('start_date', '<=', $today)
                      ->whereDate('end_date', '>=', $today);
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
        $product = Product::with('images', 'mainImage', 'variants', 'category', 'modifiers.modifier.options')
            ->where('id', $id)
            ->first();

        return view('product-detail', compact('product'));
    }

    public function addToCart(Request $request)
    {
        if ($request->is_hampers) {
            $validated = $request->validate([
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

            foreach ($hamperItems as $itemId => $qty) {
                $item = ProductVariant::with('product')->find($itemId);
                if (!$item || $item->stock < $qty) {
                    $displayName = $item->name
                        ? "{$item->product->name} - {$item->name}"
                        : $item->product->name;

                    return response()->json([
                        'success' => false,
                        'message' => "Item '{$displayName}' does not have enough stock.",
                    ]);
                }
            }

            // Add hamper to cart (session/DB logic)
            // Example:
            // Cart::addHampers(auth()->id(), $product->id, $hamperItems);

            return response()->json([
                'success' => true,
                'message' => 'Hampers successfully added to cart!',
            ]);
        } else {
            $validated = $request->validate([
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

            // Logic to add to cart here (session or DB)
            // Example:
            // Cart::add(...)

            return response()->json([
                'success' => true,
                'message' => 'Product successfully added to cart!',
            ]);
        }
    }
}

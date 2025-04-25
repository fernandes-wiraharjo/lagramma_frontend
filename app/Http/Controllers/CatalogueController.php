<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\CartService;
use Illuminate\Support\Facades\Session;

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
                    'name' => $displayName, //variant name
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

                    if (!$variant || $variant->stock < $neededQty) {
                        return response()->json([
                            'success' => false,
                            'message' => "Item '{$hamperItem['name']}' in '{$productName}' only has {$variant->stock} left.",
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

    public function viewCheckout() {
        return view('lagramma-checkout');
    }
}

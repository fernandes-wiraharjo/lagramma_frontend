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
use App\Models\OrderModifier;
use App\Models\OrderHampersItem;
use App\Services\CartService;
use App\Services\BuyNowService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

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
            // Step 1: Collect all needed quantities
            $totalVariantsNeeded = [];

            foreach ($checkoutItems as $item) {
                $key = $item['product_variant_id'];
                if (!isset($totalVariantsNeeded[$key])) {
                    $totalVariantsNeeded[$key] = 0;
                }
                $totalVariantsNeeded[$key] += $item['quantity'];

                if ($item['type'] === 'hampers') {
                    foreach ($item['items'] as $hamperItem) {
                        $key = $hamperItem['id'];
                        $neededQty = $hamperItem['quantity'] * $item['quantity'];

                        if (!isset($totalVariantsNeeded[$key])) {
                            $totalVariantsNeeded[$key] = 0;
                        }
                        $totalVariantsNeeded[$key] += $neededQty;
                    }
                }
            }

            // Step 2: Validate total stock
            foreach ($totalVariantsNeeded as $variantId => $neededQty) {
                $variant = ProductVariant::with('product')->find($variantId);
                $productName = $variant->name
                    ? "{$variant->product->name} - {$variant->name}"
                    : $variant->product->name;
                if (!$variant || $variant->stock < $neededQty) {
                    return response()->json([
                        'success' => false,
                        'message' => "Product '{$productName}' only has {$variant->stock} left.",
                    ]);
                }
            }

            // Step 3: Create order for each item
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

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'invoice_number' => $this->generateInvoiceNumber(),
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['product_variant_id'],
                    'type' => $item['type'],
                    'product_name' => $item['product_name'],
                    'product_variant_name' => $item['product_variant_name'] ?? '',
                    'quantity' => $item['quantity'],
                    'status' => 'pending',
                    'price' => $item['price'],
                    'total_price' => $totalPrice,
                    'created_by' => auth()->id(),
                    'updated_at' => null
                ]);

                // Reduce stock after order creation
                $variant = ProductVariant::find($item['product_variant_id']);
                if ($variant) {
                    $variant->stock -= $item['quantity'];
                    $variant->updated_by = auth()->id();
                    $variant->save();
                }

                // If hampers
                if ($item['type'] === 'hampers') {
                    foreach ($item['items'] as $hamperItem) {
                        OrderHampersItem::create([
                            'order_id' => $order->id,
                            'product_id' => $hamperItem['product_id'],
                            'product_variant_id' => $hamperItem['id'],
                            'product_name' => $hamperItem['product_name'],
                            'product_variant_name' => $hamperItem['name'] ?? '',
                            'quantity' => $hamperItem['quantity'] * $item['quantity'],
                            'created_by' => auth()->id(),
                            'updated_at' => null
                        ]);

                        // Reduce stock for hampers' items
                        $hamperVariant = ProductVariant::find($hamperItem['id']);
                        if ($hamperVariant) {
                            $hamperVariant->stock -= $hamperItem['quantity'] * $item['quantity'];
                            $hamperVariant->updated_by = auth()->id();
                            $hamperVariant->save();
                        }
                    }
                }

                // If modifiers exist
                if (isset($item['modifiers']) && is_array($item['modifiers']) && count($item['modifiers']) > 0) {
                    foreach ($item['modifiers'] as $modifier) {
                        OrderModifier::create([
                            'order_id' => $order->id,
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

            // Step 4: Clear session
            if ($source === 'buy_now') {
                session()->forget('buy_now');
            } else {
                session()->forget('shopping_cart');
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'redirect_url' => route('index') // or any route
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

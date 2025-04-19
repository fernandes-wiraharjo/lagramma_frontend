<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CatalogueController extends Controller
{
    public function index(Request $request) {
        $categories = Category::where('is_active', true)->get();
        $products = Product::with('category', 'mainImage')
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();
        $productsArray = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'wishList' => false,
                'productImg' => $product->mainImage?->image_path
                    ? asset(config('app.backend_url') . '/storage/' . $product->mainImage->image_path)
                    : '',
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
        $product = Product::with('images', 'mainImage')
            ->where('id', $id)
            ->first();

        return view('product-detail', compact('product'));
    }
}

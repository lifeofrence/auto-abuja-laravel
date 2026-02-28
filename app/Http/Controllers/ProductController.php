<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Product::with('business')
            ->where('is_available', true);

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $products = $query->latest()
            ->paginate(12)
            ->withQueryString();

        return view('products', compact('products', 'search'));
    }

    public function show($slug)
    {
        $product = Product::with(['business', 'images'])
            ->where('slug', $slug)
            ->where('is_available', true)
            ->firstOrFail();

        // Update views count
        $product->increment('views_count');

        $product_images = $product->images;

        $relatedProducts = Product::where('business_id', $product->business_id)
            ->where('id', '!=', $product->id)
            ->where('is_available', true)
            ->take(4)
            ->get();

        return view('product-detail', compact('product', 'product_images', 'relatedProducts'));
    }
}

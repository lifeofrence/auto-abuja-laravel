<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categorySlug = $request->input('category');
        $subcategorySlug = $request->input('subcategory');

        $query = Product::with(['business.category', 'business.subcategory', 'category', 'subcategory', 'user'])
            ->where('is_available', true)
            ->whereHas('business', function ($q) {
                $q->where('status', 'approved');
            })
            ->whereHas('user', function ($q) {
                $q->where('license_status', 'Valid');
            });

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($categorySlug) {
            $query->where(function ($q) use ($categorySlug) {
                $q->whereHas('category', function ($sq) use ($categorySlug) {
                    $sq->where('slug', $categorySlug);
                })->orWhereHas('business.category', function ($sq) use ($categorySlug) {
                    $sq->where('slug', $categorySlug);
                });
            });
        }

        if ($subcategorySlug) {
            $query->where(function ($q) use ($subcategorySlug) {
                $q->whereHas('subcategory', function ($sq) use ($subcategorySlug) {
                    $sq->where('slug', $subcategorySlug);
                })->orWhereHas('business.subcategory', function ($sq) use ($subcategorySlug) {
                    $sq->where('slug', $subcategorySlug);
                });
            });
        }

        $products = $query->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = \App\Models\Category::where('is_active', true)->orderBy('display_order')->get();

        return view('products', compact('products', 'search', 'categorySlug', 'subcategorySlug', 'categories'));
    }

    public function show($slug)
    {
        $query = Product::with(['business', 'images', 'user'])
            ->where('slug', $slug);

        // Admins can see everything, others are restricted to approved/valid/available
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'super_admin', 'moderator', 'support'])) {
            $query->where('is_available', true)
                ->whereHas('business', function ($q) {
                    $q->where('status', 'approved');
                })
                ->whereHas('user', function ($q) {
                    $q->where('license_status', 'Valid');
                });
        }

        $product = $query->firstOrFail();

        // Update views count
        $product->increment('views_count');

        $product_images = $product->images;

        $relatedProducts = Product::where('business_id', $product->business_id)
            ->where('id', '!=', $product->id)
            ->where('is_available', true)
            ->whereHas('business', function ($q) {
                $q->where('status', 'approved');
            })
            ->whereHas('user', function ($q) {
                $q->where('license_status', 'Valid');
            })
            ->take(4)
            ->get();

        return view('product-detail', compact('product', 'product_images', 'relatedProducts'));
    }
}

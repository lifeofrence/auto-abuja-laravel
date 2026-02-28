<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\Category;
use App\Models\Subcategory;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->input('category');
        $subcategorySlug = $request->input('sub');
        $search = $request->input('search');

        $query = Business::with(['category', 'subcategory'])
            ->where('status', 'approved');

        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($subcategorySlug) {
            $query->whereHas('subcategory', function ($q) use ($subcategorySlug) {
                $q->where('slug', $subcategorySlug);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('address', 'LIKE', "%{$search}%");
            });
        }

        $businesses = $query->orderByDesc('is_featured')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::where('is_active', true)->orderBy('display_order')->get();

        $subcategories = collect();
        if ($categorySlug) {
            $subcategories = Subcategory::whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            })->where('is_active', true)->orderBy('display_order')->get();
        }

        $pageTitle = "Business Listings";
        if ($categorySlug) {
            $cat = Category::where('slug', $categorySlug)->first();
            if ($cat)
                $pageTitle = $cat->name;
        }
        if ($subcategorySlug) {
            $sub = Subcategory::where('slug', $subcategorySlug)->first();
            if ($sub)
                $pageTitle .= " - " . $sub->name;
        }

        $mapBusinesses = $businesses->filter(function ($b) {
            return $b->latitude && $b->longitude;
        })->values();

        return view('listings', compact(
            'businesses',
            'categories',
            'subcategories',
            'search',
            'categorySlug',
            'subcategorySlug',
            'pageTitle',
            'mapBusinesses'
        ));
    }
}

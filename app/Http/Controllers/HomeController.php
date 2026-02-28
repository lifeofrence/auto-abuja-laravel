<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Business;
use App\Models\Product;
use App\Models\Partner;
use App\Models\Testimonial;
use App\Models\Advertisement;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categorySlug = $request->input('category');
        $subcategorySlug = $request->input('subcategory');
        $showResults = false;

        $searchBusinessResults = collect();
        $searchProductResults = collect();

        // Search logic
        if ($search || $categorySlug || $subcategorySlug) {
            $showResults = true;

            // Search Businesses
            $bQuery = Business::with(['category', 'subcategory'])
                ->where('status', 'approved');

            if ($categorySlug) {
                $bQuery->whereHas('category', function ($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            }

            if ($subcategorySlug) {
                $bQuery->whereHas('subcategory', function ($q) use ($subcategorySlug) {
                    $q->where('slug', $subcategorySlug);
                });
            }

            if ($search) {
                $bQuery->where(function ($q) use ($search) {
                    $q->where('business_name', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%")
                        ->orWhere('address', 'LIKE', "%{$search}%")
                        ->orWhereHas('products', function ($pq) use ($search) {
                            $pq->where('name', 'LIKE', "%{$search}%")
                                ->orWhere('description', 'LIKE', "%{$search}%");
                        });
                });
            }

            $searchBusinessResults = $bQuery->orderByDesc('is_featured')
                ->latest()
                ->take(12)
                ->get();

            // Search Products
            $pQuery = Product::with(['business', 'category', 'subcategory', 'business.category', 'business.subcategory'])
                ->where('is_available', true);

            if ($search) {
                $pQuery->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%");
                });
            }

            if ($categorySlug) {
                $pQuery->where(function ($q) use ($categorySlug) {
                    $q->whereHas('category', function ($sq) use ($categorySlug) {
                        $sq->where('slug', $categorySlug);
                    })->orWhereHas('business.category', function ($sq) use ($categorySlug) {
                        $sq->where('slug', $categorySlug);
                    });
                });
            }

            if ($subcategorySlug) {
                $pQuery->where(function ($q) use ($subcategorySlug) {
                    $q->whereHas('subcategory', function ($sq) use ($subcategorySlug) {
                        $sq->where('slug', $subcategorySlug);
                    })->orWhereHas('business.subcategory', function ($sq) use ($subcategorySlug) {
                        $sq->where('slug', $subcategorySlug);
                    });
                });
            }

            $searchProductResults = $pQuery->latest()->take(12)->get();
        }

        // Featured Products
        $featuredProducts = Product::with(['business', 'category', 'subcategory', 'business.category', 'business.subcategory'])
            ->where('is_available', true)
            ->orderByDesc('is_featured')
            ->latest()
            ->take(8)
            ->get();

        // Categories & Subcategories for Dropdowns
        $searchCategories = Category::where('is_active', true)->orderBy('display_order')->get();
        $searchSubcategories = Subcategory::with('category')
            ->where('is_active', true)
            ->where('slug', '!=', '')
            ->get()
            ->sortBy(function ($sc) {
                return $sc->category->display_order . '-' . $sc->display_order . '-' . $sc->id;
            });

        // Businesses by category
        $mechanics = $this->getBusinessesByCategory('mechanics');
        $dealers = $this->getBusinessesByCategory('dealers');
        $spareParts = $this->getBusinessesByCategory('spare-parts');
        $towing = $this->getBusinessesByCategory('towing');
        $recyclers = $this->getBusinessesByCategory('recyclers');

        // Partners & Testimonials
        $partners = Partner::orderBy('display_order')->get();
        $testimonials = Testimonial::latest()->get();

        // Advertisements
        $carouselAds = Advertisement::where('position', 'header')->where('is_active', true)->orderBy('display_order')->get();
        $promoAds = Advertisement::where('position', 'homepage_middle')->where('is_active', true)->orderBy('display_order')->get();

        return view('home', compact(
            'showResults',
            'searchBusinessResults',
            'searchProductResults',
            'featuredProducts',
            'searchCategories',
            'searchSubcategories',
            'mechanics',
            'dealers',
            'spareParts',
            'towing',
            'recyclers',
            'partners',
            'testimonials',
            'carouselAds',
            'promoAds',
            'search',
            'categorySlug',
            'subcategorySlug'
        ));
    }

    private function getBusinessesByCategory($slug, $limit = 8)
    {
        return Business::with('category')
            ->whereHas('category', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })
            ->where('status', 'approved')
            ->orderByDesc('is_featured')
            ->latest()
            ->take($limit)
            ->get();
    }
}

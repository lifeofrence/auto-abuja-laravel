<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;

class BusinessController extends Controller
{
    public function show($slug)
    {
        $business = Business::with([
            'category',
            'images',
            'products' => function ($q) {
                $q->where('is_available', true);
            }
        ])->where('slug', $slug)->where('status', 'approved')->firstOrFail();

        // Update views count
        $business->increment('views_count');

        $gallery = $business->images;
        $products = $business->products;
        $business_hours = json_decode($business->business_hours ?? '{}', true) ?: [];

        return view('business-detail', compact('business', 'gallery', 'products', 'business_hours'));
    }
}

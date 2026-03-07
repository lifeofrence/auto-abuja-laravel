<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;

class BusinessController extends Controller
{
    public function show($slug)
    {
        $query = Business::with([
            'category',
            'images',
            'user',
            'products' => function ($q) {
                if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'super_admin', 'moderator', 'support'])) {
                    $q->where('is_available', true)
                        ->whereHas('user', function ($uq) {
                            $uq->where('license_status', 'Valid');
                        });
                }
            }
        ])->where('slug', $slug);

        // Admins can see everything, others are restricted to approved/valid
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'super_admin', 'moderator', 'support'])) {
            $query->where('status', 'approved')
                ->whereHas('user', function ($q) {
                    $q->where('license_status', 'Valid');
                });
        }

        $business = $query->firstOrFail();

        // Update views count
        $business->increment('views_count');

        $gallery = $business->images;
        $products = $business->products;
        $hours = $business->business_hours;
        $business_hours = is_array($hours) ? $hours : (json_decode($hours ?? '{}', true) ?: []);

        return view('business-detail', compact('business', 'gallery', 'products', 'business_hours'));
    }
}

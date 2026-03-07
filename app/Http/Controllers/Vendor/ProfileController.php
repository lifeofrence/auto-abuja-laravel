<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $business = $user->businesses()->with(['products', 'images', 'category', 'subcategory'])->first();

        // If no business exists, redirect to setup
        if (!$business) {
            return redirect()->route('vendor.business.index')->with('info', 'Please complete your business profile first.');
        }

        return view('vendor.profile.index', [
            'user' => $user,
            'business' => $business,
            'products' => $business->products()->latest()->take(10)->get(),
            'gallery' => $business->images()->latest()->take(8)->get(),
        ]);
    }
}

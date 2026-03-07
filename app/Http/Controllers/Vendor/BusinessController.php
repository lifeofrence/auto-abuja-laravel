<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BusinessController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $business = $user->businesses()->first();

        // Pre-fill from User model (VIO data) if business doesn't exist
        $prefill = [
            'business_name' => $user->business_name,
            'address' => $user->business_address,
            'location' => $user->business_location,
            'phone' => $user->phone,
            'email' => $user->email,
        ];

        return view('vendor.business.setup', [
            'business' => $business,
            'prefill' => $prefill,
            'categories' => Category::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'google_maps_link' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'business_hours' => 'nullable|array',
        ]);

        $user = Auth::user();
        $businessData = [
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'business_name' => $request->business_name,
            'slug' => Str::slug($request->business_name) . '-' . $user->id,
            'address' => $request->address,
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
            'email' => $request->email,
            'description' => $request->description,
            'website' => $request->website,
            'google_maps_link' => $request->google_maps_link,
            'business_hours' => $request->business_hours, // casting will handle JSON
            'status' => 'pending',
        ];

        // Handle Logo Upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('business/logos', 'public');
            $businessData['logo'] = $logoPath;
        }

        // Handle Cover Image Upload
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('business/covers', 'public');
            $businessData['cover_image'] = $coverPath;
        }

        $business = Business::updateOrCreate(
            ['user_id' => $user->id],
            $businessData
        );

        return redirect()->route('vendor.business.index')->with('status', 'Business information updated successfully!');
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }
}

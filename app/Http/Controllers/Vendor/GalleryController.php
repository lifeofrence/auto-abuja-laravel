<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\BusinessImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    public function index()
    {
        $business = Auth::user()->businesses()->first();
        if (!$business) {
            return redirect()->route('vendor.business.index')->with('error', 'Setup your business profile first.');
        }

        return view('vendor.gallery.index', [
            'images' => $business->images()->where('is_visible', true)->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|max:5120',
        ]);

        $business = Auth::user()->businesses()->first();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('business/gallery', 'public');
                BusinessImage::create([
                    'business_id' => $business->id,
                    'image_path' => $path,
                    'is_visible' => true,
                ]);
            }
        }

        return redirect()->route('vendor.gallery.index')->with('status', 'Images added to gallery successfully!');
    }

    public function destroy($id)
    {
        $image = BusinessImage::findOrFail($id);
        $business = Auth::user()->businesses()->first();

        if ($image->business_id !== $business->id) {
            abort(403);
        }

        $image->update(['is_visible' => false]);
        return redirect()->route('vendor.gallery.index')->with('status', 'Image hidden from gallery.');
    }
}

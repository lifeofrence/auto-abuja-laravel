<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $business = Auth::user()->businesses()->first();
        if (!$business) {
            return redirect()->route('vendor.business.index')->with('error', 'Setup your business profile first.');
        }

        $products = Product::where('business_id', $business->id)
            ->with(['category', 'subcategory'])
            ->latest()
            ->paginate(10);

        return view('vendor.products.index', compact('products'));
    }

    public function toggleAvailability($id)
    {
        $product = Product::findOrFail($id);
        $business = Auth::user()->businesses()->first();

        if ($product->business_id !== $business->id) {
            abort(403);
        }

        $product->is_available = !$product->is_available;
        $product->save();

        $status = $product->is_available ? 'Product is now Live on the Marketplace!' : 'Product is now hidden from the Public.';

        return back()->with('status', $status);
    }

    public function create()
    {
        $business = Auth::user()->businesses()->with('category.subcategories')->first();
        if (!$business) {
            return redirect()->route('vendor.business.index')->with('error', 'Setup your business profile first.');
        }

        return view('vendor.products.create', [
            'business' => $business,
            'category' => $business->category,
            'subcategories' => $business->category ? $business->category->subcategories : collect(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'required|image|max:5120',
            'additional_images.*' => 'nullable|image|max:5120',
        ]);

        $user = Auth::user();
        $business = $user->businesses()->first();

        $imagePath = $request->file('image')->store('products', 'public');

        $product = Product::create([
            'user_id' => $user->id,
            'business_id' => $business->id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'status' => 'approved',
        ]);

        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('vendor.profile')->with('status', 'Product posted successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $business = Auth::user()->businesses()->first();

        if ($product->business_id !== $business->id) {
            abort(403);
        }

        return view('vendor.products.edit', [
            'product' => $product->load('images'),
            'category' => $business->category,
            'subcategories' => $business->category ? $business->category->subcategories : collect(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $business = Auth::user()->businesses()->first();

        if ($product->business_id !== $business->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'additional_images.*' => 'nullable|image|max:5120',
        ]);

        $updateData = [
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $updateData['image'] = $imagePath;
        }

        $product->update($updateData);

        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('vendor.profile')->with('status', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $business = Auth::user()->businesses()->first();

        if ($product->business_id !== $business->id) {
            abort(403);
        }

        $product->update(['is_available' => false]);
        return redirect()->route('vendor.products.index')->with('status', 'Product listing deactivated and hidden from the marketplace.');
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $product = $image->product;
        $business = Auth::user()->businesses()->first();

        if ($product->business_id !== $business->id) {
            abort(403);
        }

        $image->update(['is_visible' => false]);
        return back()->with('status', 'Image hidden from gallery.');
    }
}

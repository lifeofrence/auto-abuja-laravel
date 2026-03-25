<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('manage-operations');
        $query = Product::with(['user', 'business', 'category']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('price', 'like', "%{$search}%")
                    ->orWhereHas('business', function ($q) use ($search) {
                        $q->where('business_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('subcategory', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $products = $query->latest()->paginate(20)->appends($request->all());

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        Gate::authorize('manage-operations');
        $businesses = Business::orderBy('business_name')->get();
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('businesses', 'categories'));
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-operations');

        $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|max:5120',
            'additional_images.*' => 'nullable|image|max:5120',
        ]);

        $business = Business::findOrFail($request->business_id);

        $imagePath = $request->file('image')->store('uploads/products', 'public_uploads');

        $product = Product::create([
            'user_id' => $business->user_id,
            'business_id' => $request->business_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'status' => 'approved',
            'is_available' => true,
        ]);

        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('uploads/products/gallery', 'public_uploads');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('status', 'Product created successfully.');
    }

    public function toggleAvailability($id)
    {
        Gate::authorize('manage-operations');
        $product = Product::findOrFail($id);
        $product->update(['is_available' => !$product->is_available]);

        $status = $product->is_available ? 'activated' : 'deactivated';
        return back()->with('status', "Product '{$product->name}' has been {$status}.");
    }

    public function destroy($id)
    {
        Gate::authorize('manage-operations');
        $product = Product::findOrFail($id);
        $product->delete();

        return back()->with('status', "Product permanently removed.");
    }

    public function edit($id)
    {
        Gate::authorize('manage-operations');
        $product = Product::with('images')->findOrFail($id);
        $businesses = Business::orderBy('business_name')->get();
        $categories = Category::orderBy('name')->get();
        
        $subcategories = collect();
        if ($product->category_id) {
            $category = Category::with('subcategories')->find($product->category_id);
            if ($category) {
                $subcategories = $category->subcategories;
            }
        }

        return view('admin.products.edit', compact('product', 'businesses', 'categories', 'subcategories'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('manage-operations');
        $product = Product::findOrFail($id);

        $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:5120',
            'additional_images.*' => 'nullable|image|max:5120',
        ]);

        $updateData = [
            'business_id' => $request->business_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'description' => $request->description,
            'price' => $request->price,
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/products', 'public_uploads');
            $updateData['image'] = $imagePath;
        }

        $product->update($updateData);

        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('uploads/products/gallery', 'public_uploads');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('status', 'Product updated successfully.');
    }

    public function deleteImage($id)
    {
        Gate::authorize('manage-operations');
        $image = ProductImage::findOrFail($id);
        
        // Vendor deletes logic
        // We will just physically delete it as admin
        $image->delete();
        
        return back()->with('status', 'Image removed from gallery.');
    }
}

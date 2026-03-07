<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
}

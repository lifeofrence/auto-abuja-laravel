<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class SubcategoryController extends Controller
{
    public function index($categoryId)
    {
        Gate::authorize('manage-categories');
        $category = Category::withCount('subcategories')->findOrFail($categoryId);
        $subcategories = $category->subcategories()->withCount('products')->get();

        return view('admin.categories.subcategories', compact('category', 'subcategories'));
    }

    public function store(Request $request, $categoryId)
    {
        Gate::authorize('manage-categories');
        $category = Category::findOrFail($categoryId);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'badge_color' => 'nullable|string|max:50',
        ]);

        $category->subcategories()->create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'badge_color' => $request->badge_color ?? 'primary',
            'is_active' => true,
        ]);

        return back()->with('status', "Subcategory '{$request->name}' created successfully!");
    }

    public function toggle($id)
    {
        Gate::authorize('manage-categories');
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->update(['is_active' => !$subcategory->is_active]);

        return back()->with('status', "Subcategory '{$subcategory->name}' status updated.");
    }
}

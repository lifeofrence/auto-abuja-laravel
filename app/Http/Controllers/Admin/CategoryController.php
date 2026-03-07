<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function index()
    {
        Gate::authorize('manage-categories');
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-categories');
        $request->validate([
            'name' => 'required|string|unique:categories,name|max:255',
            'icon' => 'nullable|string'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon ?? 'fa-tag',
            'is_active' => true
        ]);

        return back()->with('status', 'Category created successfully!');
    }

    public function toggle($id)
    {
        Gate::authorize('manage-categories');
        $category = Category::findOrFail($id);
        $category->update(['is_active' => !$category->is_active]);

        return back()->with('status', "Category '{$category->name}' status updated.");
    }
}

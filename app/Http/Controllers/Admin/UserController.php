<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('manage-users');
        $query = User::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(20)->appends($request->all());
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        Gate::authorize('manage-users');
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-users');
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:user,vendor,admin,super_admin,moderator,support',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'status' => 'active',
            'license_status' => 'Valid'
        ]);

        return redirect()->route('admin.users.index')->with('status', "Account '{$request->name}' created successfully.");
    }

    public function show($id)
    {
        Gate::authorize('manage-users');
        $user = User::with(['business.category', 'products.category'])->findOrFail($id);
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('admin.users.show', compact('user', 'categories'));
    }

    public function updateBusiness(Request $request, $id)
    {
        Gate::authorize('manage-users');
        $user = User::findOrFail($id);
        $business = $user->business ?: new \App\Models\Business(['user_id' => $user->id]);

        $request->validate([
            'business_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'phone' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url',
            'google_maps_link' => 'nullable|url',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected,disabled',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'business_hours' => 'nullable|array',
        ]);

        $businessData = $request->only([
            'business_name',
            'category_id',
            'subcategory_id',
            'phone',
            'whatsapp',
            'email',
            'website',
            'google_maps_link',
            'address',
            'description',
            'status',
            'business_hours'
        ]);

        if (!$business->slug || $business->business_name !== $request->business_name) {
            $businessData['slug'] = \Illuminate\Support\Str::slug($request->business_name) . '-' . $user->id;
        }

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

        $business->fill($businessData)->save();

        return back()->with('status', 'Business profile updated successfully.');
    }

    public function edit($id)
    {
        Gate::authorize('manage-users');
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('manage-users');
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,vendor,admin,super_admin,moderator,support',
            'status' => 'required|in:active,disabled,pending',
            'phone' => 'nullable|string|max:20',
            'vio_user_id' => 'nullable|string|max:255',
            'license_status' => 'nullable|string|in:Valid,Expired'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'phone' => $request->phone,
            'vio_user_id' => $request->vio_user_id,
            'license_status' => $request->license_status,
        ]);

        return back()->with('status', "User '{$user->name}' updated successfully.");
    }

    public function updateRole(Request $request, $id)
    {
        Gate::authorize('manage-users');
        $user = User::findOrFail($id);
        $request->validate([
            'role' => 'required|in:user,vendor,admin,super_admin,moderator,support'
        ]);

        $user->update(['role' => $request->role]);
        return back()->with('status', "User '{$user->name}' role updated to {$request->role}.");
    }

    public function resetPassword($id)
    {
        Gate::authorize('manage-users');
        $user = User::findOrFail($id);
        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
        ]);

        return back()->with('status', "Password for '{$user->name}' has been reset to the default (12345678).");
    }

    public function destroy($id)
    {
        Gate::authorize('manage-users');
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return back()->with('error', "You cannot delete yourself!");
        }

        $user->delete();
        return back()->with('status', "User deleted successfully.");
    }
}

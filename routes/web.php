<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/listings', [ListingController::class, 'index'])->name('listings');
Route::get('/business/{slug}', [App\Http\Controllers\BusinessController::class, 'show'])->name('business.show');
Route::get('/product', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/faq', 'faq')->name('faq');
Route::view('/service', 'service')->name('service');

Route::get('/team', function () {
    $businesses = App\Models\Business::with(['category', 'user'])
        ->where('status', 'approved')
        ->latest()
        ->get();
    return view('team', compact('businesses'));
})->name('team');

Route::get('/testimonial', function () {
    $testimonials = App\Models\Testimonial::latest()->get();
    return view('testimonial', compact('testimonials'));
})->name('testimonial');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Vendor Business Management
    Route::prefix('vendor')->name('vendor.')->group(function () {
        Route::get('/profile', [App\Http\Controllers\Vendor\ProfileController::class, 'index'])->name('profile');

        Route::get('/business', [App\Http\Controllers\Vendor\BusinessController::class, 'index'])->name('business.index');
        Route::post('/business', [App\Http\Controllers\Vendor\BusinessController::class, 'store'])->name('business.store');

        Route::get('/products', [App\Http\Controllers\Vendor\ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [App\Http\Controllers\Vendor\ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [App\Http\Controllers\Vendor\ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [App\Http\Controllers\Vendor\ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [App\Http\Controllers\Vendor\ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [App\Http\Controllers\Vendor\ProductController::class, 'destroy'])->name('products.destroy');
        Route::delete('/products/image/{id}', [App\Http\Controllers\Vendor\ProductController::class, 'deleteImage'])->name('products.delete_image');
        Route::post('/products/{id}/toggle', [App\Http\Controllers\Vendor\ProductController::class, 'toggleAvailability'])->name('products.toggle');

        Route::get('/gallery', [App\Http\Controllers\Vendor\GalleryController::class, 'index'])->name('gallery.index');
        Route::post('/gallery', [App\Http\Controllers\Vendor\GalleryController::class, 'store'])->name('gallery.store');
        Route::delete('/gallery/{id}', [App\Http\Controllers\Vendor\GalleryController::class, 'destroy'])->name('gallery.destroy');

        Route::get('/subcategories/{categoryId}', [App\Http\Controllers\Vendor\BusinessController::class, 'getSubcategories'])->name('subcategories');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
        // Business Management
        Route::get('/businesses', [App\Http\Controllers\Admin\BusinessController::class, 'index'])->name('businesses.index');
        Route::post('/businesses/{id}/approve', [App\Http\Controllers\Admin\BusinessController::class, 'approve'])->name('businesses.approve');
        Route::post('/businesses/{id}/suspend', [App\Http\Controllers\Admin\BusinessController::class, 'suspend'])->name('businesses.suspend');
        Route::delete('/businesses/{id}', [App\Http\Controllers\Admin\BusinessController::class, 'destroy'])->name('businesses.destroy');

        // User Management
        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
        Route::get('/users/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        Route::put('/users/{id}/business', [App\Http\Controllers\Admin\UserController::class, 'updateBusiness'])->name('users.update_business');
        Route::patch('/users/{id}/role', [App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.update_role');
        Route::delete('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{id}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset_password');

        // Product Moderation
        Route::get('/products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
        Route::post('/products/{id}/toggle', [App\Http\Controllers\Admin\ProductController::class, 'toggleAvailability'])->name('products.toggle');
        Route::delete('/products/{id}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');

        // Category Management
        Route::get('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
        Route::post('/categories/{id}/toggle', [App\Http\Controllers\Admin\CategoryController::class, 'toggle'])->name('categories.toggle');

        // Subcategories Management
        Route::get('/categories/{category}/subcategories', [App\Http\Controllers\Admin\SubcategoryController::class, 'index'])->name('categories.subcategories');
        Route::post('/categories/{category}/subcategories', [App\Http\Controllers\Admin\SubcategoryController::class, 'store'])->name('categories.subcategories.store');
        Route::post('/subcategories/{id}/toggle', [App\Http\Controllers\Admin\SubcategoryController::class, 'toggle'])->name('subcategories.toggle');
    });
});

Route::get('/api/subcategories', function (\Illuminate\Http\Request $request) {
    $categorySlug = $request->query('category');
    if (!$categorySlug) {
        return response()->json([]);
    }
    $category = App\Models\Category::where('slug', $categorySlug)->first();
    if (!$category) {
        return response()->json([]);
    }
    $subcategories = $category->subcategories()->select('id', 'name', 'slug')->get();
    return response()->json($subcategories);
})->name('api.subcategories');

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

require __DIR__ . '/auth.php';

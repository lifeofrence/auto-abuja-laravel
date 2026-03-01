<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});


require __DIR__ . '/auth.php';

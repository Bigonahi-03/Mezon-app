<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\ProductSizeController;

// Dashboard
Route::get('/', [HomeController::class, 'index'])->name('dashboard');
// -----------------------------------------------------------------------------------------------

// Sliders
// Route::group(['prefix' => 'sliders'], function(){
//     Route::get('/', [SliderController::class, 'index'])->name('sliders.index');
//     Route::get('/create', [SliderController::class, 'create'])->name('sliders.create');
//     Route::post('/', [SliderController::class, 'store'])->name('sliders.store');
//     Route::get('/{slider}/edit', [SliderController::class, 'edit'])->name('sliders.edit');
//     Route::put('/{slider}', [SliderController::class, 'update'])->name('sliders.update');
//     Route::delete('/{slider}', [SliderController::class, 'destroy'])->name('sliders.destroy');
    
// });
Route::resource('sliders', SliderController::class)->except(['show']);
Route::fallback(function () {
    return redirect()->route('sliders.index')->with('error', 'مسیر مورد نظر پشتیبانی نمی‌شود.');
});
// -----------------------------------------------------------------------------------------------


// Feature
// Route::group(['prefix' => 'features'], function(){
//     Route::get('/', [FeatureController::class, 'index'])->name('features.index');
//     Route::get('/create', [FeatureController::class, 'create'])->name('features.create');
//     Route::post('/', [FeatureController::class, 'store'])->name('features.store');
//     Route::get('/{feature}/edit', [FeatureController::class, 'edit'])->name('features.edit');
//     Route::put('/{feature}', [FeatureController::class, 'update'])->name('features.update');
//     Route::delete('/{feature}', [FeatureController::class, 'destroy'])->name('features.destroy');
// });
Route::resource('features', FeatureController::class)->except(['show']);
Route::fallback(function () {
    return redirect()->route('feature')->with('error', 'مسیر مورد نظر پشتیبانی نمی‌شود.');
});
// -----------------------------------------------------------------------------------------------



// AboutUs
// Route::group(['prefix' => 'about-us'], function(){
//     Route::get('/', [AboutUsController::class, 'index'])->name('about-us.index');
//     Route::get('/{aboutUs}/edit', [AboutUsController::class, 'edit'])->name('about-us.edit');
//     Route::put('/{aboutUs}', [AboutUsController::class, 'update'])->name('about-us.update');
// });
Route::resource('about-us', AboutUsController::class)->only(['index', 'update', 'edit']);
Route::fallback(function () {
    return redirect()->route('about-us')->with('error', 'مسیر مورد نظر پشتیبانی نمی‌شود.');
});
// -----------------------------------------------------------------------------------------------



// Contact-us
// Route::group(['prefix' => 'contact-us'], function(){
//     Route::get('/', [ContactUsController::class, 'index'])->name('contact-us.index');
//     Route::get('/{contactUs}/show', [ContactUsController::class, 'show'])->name('contact-us.show');
//     Route::delete('/{contactUs}', [ContactUsController::class, 'destroy'])->name('contact-us.destroy');
// });  
Route::resource('contact-us', ContactUsController::class)->only(['index', 'show', 'destroy']);
Route::fallback(function () {
    return redirect()->route('about_us')->with('error', 'مسیر مورد نظر پشتیبانی نمی‌شود.');
});
// -----------------------------------------------------------------------------------------------


// Categories
Route::group(['prefix' => 'categories'], function(){
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/create', [CategoryController::class, 'createMain'])->name('category.create');
    Route::get('/create/subcategory/{parent}', [CategoryController::class, 'createSub'])->name('category.create.sub');
    Route::post('/create', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/{category}/edit', [CategoryController::class, 'editMain'])->name('category.edit');
    Route::get('/edit/subcategory/{parent}', [CategoryController::class, 'editSub'])->name('category.edit.sub');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::fallback(function () {
        return redirect()->route('category')->with('error', 'مسیر مورد نظر پشتیبانی نمی‌شود.');
    });
});
// -----------------------------------------------------------------------------------------------

// Sizes
// Route::group(['prefix' => 'sizes'], function(){
//     Route::get('/', [SizeController::class, 'index'])->name('size.index');
//     Route::post('/create', [SizeController::class, 'store'])->name('size.store');
//     Route::put('/{size}', [SizeController::class, 'update'])->name('size.update');
//     Route::delete('/{size}', [SizeController::class, 'destroy'])->name('size.destroy');
// });
Route::resource('sizes', SizeController::class)->only(['index', 'store', 'update', 'destroy']);
Route::fallback(function () {
    return redirect()->route('sizes')->with('error', 'مسیر مورد نظر پشتیبانی نمی‌شود.');
});
// -----------------------------------------------------------------------------------------------

// Products
// Route::group(['prefix' => 'products'], function(){
//     Route::get('/', [ProductController::class, 'index'])->name('products.index');
//     Route::get('/create', [ProductController::class, 'create'])->name('products.create');
//     Route::post('/', [ProductController::class, 'store'])->name('products.store');
//     Route::get('/{product}/show', [ProductController::class, 'show'])->name('products.show');
//     Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
//     Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
//     Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
// });
Route::resource('products', ProductController::class);
Route::fallback(function () {
    return redirect()->route('products.index')->with('error', 'مسیر مورد نظر پشتیبانی نمی‌شود.');
});
// -----------------------------------------------------------------------------------------------

// Pruduct Size
Route::prefix('/pruducts/{product}')->group(function(){
    Route::get('/sizes', [ProductSizeController::class, 'index'])->name('products.sizes.index');
    Route::post('/sizes', [ProductSizeController::class, 'store'])->name('products.sizes.store');
    Route::put('/sizes/{size}', [ProductSizeController::class, 'update'])->name('products.sizes.update');
    Route::delete('/sizes/{size}', [ProductSizeController::class, 'destroy'])->name('products.sizes.destroy');
    Route::delete('/sizes/{size}', [ProductSizeController::class, 'destroy'])->name('products.sizes.destroy');
});










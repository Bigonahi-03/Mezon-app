<?php

use App\Models\ContactUs;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactUsController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about_us', function(){
    return view('about_us');
})->name('about_us');

Route::prefix('contact_us')->group(function () {
    Route::get('/', [ContactUsController::class, 'index'])->name('contact_us');
    Route::post('/', [ContactUsController::class, 'store'])->name('contact_us.store');
});

Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/menu', [ProductController::class, 'menu'])->name('products.menu');


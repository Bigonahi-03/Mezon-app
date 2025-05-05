<?php

use App\Models\ContactUs;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactUsController;

//روت صفحه اصلی
Route::get('/', [HomeController::class, 'index'])->name('home');

//روت صفحه درباره ما
Route::get('/about_us', function(){
    return view('about_us');
})->name('about_us');

//روت صفحه تماس با ما
Route::prefix('contact_us')->group(function () {
    Route::get('/', [ContactUsController::class, 'index'])->name('contact_us');
    Route::post('/', [ContactUsController::class, 'store'])->name('contact_us.store');
});

//روت صفحه محصولات
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

//روت صفحه منو
Route::get('/menu', [ProductController::class, 'menu'])->name('products.menu');

//روت صفحه ثبت نام

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.loginForm');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/auth/check-otp', [AuthController::class, 'checkOtp'])->name('auth.checkOtp');
    Route::post('/auth/resend-otp', [AuthController::class, 'resendOtp'])->name('auth.resendOtp');
});

Route::middleware('auth')->group(function () {  
    Route::get('/test', function(){
        return 'test';
    });
});


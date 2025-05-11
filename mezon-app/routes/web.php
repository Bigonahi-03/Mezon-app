<?php

use App\Models\ContactUs;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\ProfileController;

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

Route::get('/logout', [AuthController::class, 'logout'])->name('profile.logout');


//روت صفحه پروفایل      
Route::prefix('profile')->middleware('auth')->group(function(){
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/address', [ProfileController::class, 'address'])->name('profile.address');
    Route::post('/address', [ProfileController::class, 'addressStore'])->name('profile.address.store');
    Route::put('/address', [ProfileController::class, 'addressUpdate'])->name('profile.address.update');

    Route::get('/profile/wishlist', [ProfileController::class, 'wishlist'])->name('profile.wishlist');
    Route::get('/profile/wishlist/remove', [ProfileController::class, 'removeFromWishlist'])->name('profile.wishlist.remove');


});

Route::get('/profile/add-to-wishlist', [ProfileController::class, 'addToWishlist'])->name('profile.wishlist.add');



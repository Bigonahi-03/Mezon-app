<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

/**
 * کنترلر احراز هویت کاربران
 * 
 * این کنترلر مسئول مدیریت فرآیند ورود کاربران با استفاده از OTP است
 */
class AuthController extends Controller
{
    /**
     * نمایش فرم ورود در صفحه اصلی
     * 
     * این متد کاربر را به صفحه اصلی با پارامتر show_modal=login هدایت می‌کند
     * تا مودال ورود به صورت خودکار نمایش داده شود
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginForm()
    {
        return redirect()->route('home', ['show_modal' => 'login']);
    }

    /**
     * ارسال کد تایید به شماره موبایل کاربر
     * 
     * این متد شماره موبایل کاربر را دریافت کرده و یک کد تایید تصادفی تولید می‌کند
     * سپس این کد را از طریق پیامک به کاربر ارسال می‌کند
     *
     * @param Request $request درخواست حاوی شماره موبایل کاربر
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
       $request->validate([
        'cellphone' => ['required', 'regex:/^09[0-9]{9}$/']  
       ]);

       $otpCoad = mt_rand(100000, 999999);
       $loginToken = Hash::make($otpCoad . time());

       try {
           $user = User::where('cellphone', $request->cellphone)->first();

           if ($user) {
               $user->update([
                   'otp' => $otpCoad,
                   'login_token' => $loginToken
               ]);
           } else {
               $user = User::create([
                   'cellphone' => $request->cellphone,
                   'otp' => $otpCoad,
                   'login_token' => $loginToken
               ]);
           }

           sendOtpSms($request->cellphone, $otpCoad);

           return response()->json(['message' => 'کد تایید برای شماره موبایل '. '(' . $request->cellphone . ')' . ' ارسال شد', 'login_token' => $loginToken
           ], 200);
       } catch(Exception $e) {
           Log::error("Error in login process: " . $e->getMessage());
           return response()->json([
               'message' => 'خطایی در فرآیند ورود رخ داد. لطفاً دوباره تلاش کنید.',
               'error' => env('APP_ENV') === 'local' ? $e->getMessage() : null
           ], 500);
       }
    }

    /**
     * بررسی کد تایید وارد شده توسط کاربر
     * 
     * این متد کد تایید وارد شده توسط کاربر را با کد ذخیره شده در دیتابیس مقایسه می‌کند
     * در صورت صحیح بودن، کاربر را وارد سیستم می‌کند
     *
     * @param Request $request درخواست حاوی کد تایید و توکن ورود
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkOtp(Request $request){
        $request->validate([
            'otp' => 'required|digits:6',
            'login_token' => 'required'
        ]);

        try {
            $user = User::where('login_token', $request->login_token)->firstOrFail();

            if ($user->otp == $request->otp){
                Auth::login($user, $remember = true);
                return response()->json([
                    'message' => 'ورود با موفقیت انجام شد',
                    'closeModal' => true
                ], 200);
            } else {
                return response()->json(['message' => 'کد تایید نامعتبر است'], 422);
            }
        } catch(Exception $e) {
            Log::error("Error in otpCheck: " . $e->getMessage());
            return response()->json([
                'message' => 'خطایی در فرآیند ورود رخ داد. لطفاً دوباره تلاش کنید.',
                'error' => env('APP_ENV') === 'local' ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * ارسال مجدد کد تایید
     * 
     * این متد یک کد تایید جدید تولید کرده و آن را برای کاربر ارسال می‌کند
     * معمولاً زمانی استفاده می‌شود که کاربر کد قبلی را دریافت نکرده یا منقضی شده است
     *
     * @param Request $request درخواست حاوی توکن ورود
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendOtp(Request $request)
    {
       $request->validate([
        'login_token' => 'required'  
       ]);

       $user = User::where('login_token', $request->login_token )->firstOrFail();
       $otpCoad = mt_rand(100000, 999999);
       $loginToken = Hash::make($otpCoad . time());

       try {
           $user->update([
               'otp' => $otpCoad,
               'login_token' => $loginToken
           ]);

           sendOtpSms($user->cellphone, $otpCoad);

           return response()->json(['message' => 'کد تایید برای شماره موبایل '. '(' . $user->cellphone . ')' .  ' مجدد ارسال شد', 'login_token' => $loginToken], 200);

       } catch(Exception $e) {
           Log::error("Error in login process: " . $e->getMessage());
           return response()->json([
               'message' => 'خطایی در فرآیند ورود رخ داد. لطفاً دوباره تلاش کنید.',
               'error' => env('APP_ENV') === 'local' ? $e->getMessage() : null
           ], 500);
       }
    }
}

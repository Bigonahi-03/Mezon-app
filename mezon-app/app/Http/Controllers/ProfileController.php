<?php

namespace App\Http\Controllers;

use id;
use Exception;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

/*
*کنترولر پروفایل کاربران
*
*این کنترولر برای مدیریت پروفایل کاربران است
*/

class ProfileController extends Controller
{

    /**
     * 
     * نمایش صفحه پروفایل
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * 
     * اطلاعات وارد شده توسط کاربر را اعتبار سنجی می‌کند و 
     * اطلاعات کاربر عضو شده را ویرایش می‌کند
     * 
     * @param Request $request درخواست حاوی نام و ایمیل کاربر
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id
        ]);

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
            return redirect()->route('profile.index')->with('success', 'ویرایش پروفایل با موفقیت انجام شد😊');
        } catch (Exception $e) {
            Log::error('Error update profile: ' . $e->getMessage());
            return redirect()->route('profile.index')->with('error', 'ویرایش پروفایل با خطا مواجه شد لطفا دوباره تلاش کنید');
        }
    }

    /**
     * 
     * نمایش صفحه آدرس کاربر
     *
     * @return \Illuminate\View\View
     */
    public function address()
    {
        $user = Auth::user();
        $userAddress = $user->address;
        return view('profile.address', compact('userAddress'));
    }

    public function addressStore(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'province' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'postal_code' => ['required', 'regex:/^\d{5}[ -]?\d{5}$/'],
            'cellphone' => ['required', 'regex:/^09[0-9]{9}$/'],
            'lat' => 'numeric',
            'lng' => 'numeric'
        ]);

        try {
            if ($user->address) {
                $user->address->update([
                    'province' => $request->province,
                    'city' => $request->city,
                    'address' => $request->address,
                    'postal_code' => $request->postal_code,
                    'cellphone' => $request->cellphone,
                    'latitude' => $request->lat,
                    'longitude' => $request->lng
                ]);
            } else {
                $user->address()->create([
                    'province' => $request->province,
                    'city' => $request->city,
                    'address' => $request->address,
                    'postal_code' => $request->postal_code,
                    'cellphone' => $request->cellphone,
                    'latitude' => $request->lat,
                    'longitude' => $request->lng
                ]);
            }
            return redirect()->route('profile.address')->with('success', 'آدرس با موفقیت ذخیره شد');
        } catch (Exception $e) {
            Log::error('Error store address: ' . $e->getMessage());
            return redirect()->route('profile.address')->with('error', 'ذخیره آدرس با خطا مواجه شد');
        }
    }

    public function addToWishlist(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id'
        ]);
    
        if (!Auth::check()) {
            return redirect()->back()->with('login', 'برای ثبت در علاقه‌مندی‌ها ابتدا وارد سیستم شوید!');
        }
    
        $user = Auth::user();
        $wishlistItem = Wishlist::where('user_id', $user->id)->where('product_id', $request->product_id);
    
        if (!$wishlistItem->exists()) {
            // افزودن محصول به لیست علاقه‌مندی‌ها
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id
            ]);
    
            return redirect()->back()->with('wishlist_added', 'محصول به لیست علاقه‌مندی‌ها اضافه شد.');
        } else {
            // حذف محصول از لیست علاقه‌مندی‌ها
            $wishlistItem->delete();
    
            return redirect()->back()->with('warning', 'محصول از لیست علاقه‌مندی‌ها حذف شد.');
        }
    }
    
    

    public function wishlist()
    {
        $wishlist = Auth::user()->wishlist()->with('product')->get();
        return view('profile.wishlist', compact('wishlist'));
    }
    

    public function removeFromWishlist(Request $request)
    {
        $user = Auth::user();
        $wishlistItem = Wishlist::where('user_id', $user->id)->where('product_id', $request->product_id)->first();
    
        // dd($request->product_id);

        if ($wishlistItem) {
            $wishlistItem->delete();
            return redirect()->back()->with('warning', 'محصول از لیست علاقه‌مندی‌ها حذف شد.');
        } else {
            return redirect()->back()->with('error', 'این محصول در لیست علاقه‌مندی‌ها یافت نشد.');
        }
    }


    
    
}

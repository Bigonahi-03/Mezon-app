<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SizeController extends Controller
{
    /** * Display a listing of the resource.
     * تمام سایز ها را از جدول سایز ها دریافت می کند به ویو می ارسال می کند
     * @return \Illuminate\View\View
     *  */ 
    public function index()
    {
        $sizes = Size::all();
        return view('sizes.index', compact('sizes'));
    }

    /**
     * Validate the size input from the request.
     * این متد مقدار سایز را بررسی می‌کند که:
     * 1. مقدار وارد شده خالی نباشد (required).
     * 2. در جدول سایزها یکتا باشد. (برای ویرایش، آی‌دی فعلی مستثنی است)
     *
     * @param \Illuminate\Http\Request $request درخواست حاوی اطلاعات سایز
     * @param int|null $sizeId آی‌دی سایز (در صورت ویرایش)
     * @return void
     */
    private function ValidationSize(Request $request, $sizeId = null)
    {
        $uniqueRule = $sizeId ? 'unique:sizes,size,' . $sizeId : 'unique:sizes,size';
        $request->validate(['size' => 'required|' . $uniqueRule]);
    }
    
    /** * Store a newly created resource in storage. 
     * درخواست ها را اعتبار سنجی می کند و یک رکورد جدید در جدول سایز ها ذخیره می کند
     * @param \Illuminate\Http\Request $request دریافت داده ها برای ذخیره
     * @param \App\Models\Slider $slider مدل سایز برای ساخت یک رکورد جدید   
     * @return 
     * */ 
    public function store(Request $request)
    {
        // اعتبارسنجی درخواست ها با تابع ValidationSize 
        $this->ValidationSize($request);
        try {
            Size::create(['size' => $request->size]);
            return redirect()->route('sizes.index')->with('success', ' سایز با موفقیت ایجاد شد.');
        } catch (Exception $e) {
            Log::error("Error updating size: " . $e->getMessage());
            return redirect()->route('sizes.index')->with('error', 'ایجاد سایز با خطا مواجه شد. لطفاً دوباره امتحان کنید.' . (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.'));
        }
    }
    /** * Update the specified resource in storage. 
     * درخواست ها را اعتبار سنجی می کند و رکورد در جدول سایز ها ویرایش می کند
     * @param \Illuminate\Http\Request $request دریافت داده ها برای ویرایش
     * @param \App\Models\Slider $slider مدل سایز برای ویرایش رکورد   
     * @return \Illuminate\Http\RedirectResponse
     * */ 
    public function update(Request $request, Size $size)
    {
        $this->ValidationSize($request, $size->id);
        try {
            $size->update(['size' => $request->size]);
            return redirect()->route('sizes.index')->with('success', ' سایز با موفقیت ویرایش شد.');
        } catch (Exception $e) {
            Log::error("Error updating size: " . $e->getMessage());
            return redirect()->route('sizes.index')->with('error', 'ویرایش سایز با خطا مواجه شد. لطفاً دوباره امتحان کنید.' . (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.'));
        }
    }

    /** * Remove the specified resource from storage. 
     * سایز مشخص شده توسط کاربر را حذف می کند
     * @param \App\Models\Size $size مدل سایز برای حذف داده را دریافت می کند
     * @return \Illuminate\Http\RedirectResponse
     * */ 
    public function destroy(Size $size)
    {
        try {
            $size->delete();
            return redirect()->route('sizes.index')->with('success', ' سایز با موفقیت حذف شد.');
        } catch (Exception $e) {
            Log::error("Error deleting size: " . $e->getMessage());
            return redirect()->route('sizes.index')->with('error', 'حذف ویژگی با خطا مواجه شد. لطفاً دوباره امتحان کنید.' . (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.'));
        }
    }
}

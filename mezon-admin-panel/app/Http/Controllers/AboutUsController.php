<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     * اولین رکورد از جدول درباره ما را به ویو ارسال می کند
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $aboutUs = AboutUs::first();
        return view('about.index', compact('aboutUs'));
    }
    
    
    /**
     * Show the form for editing the specified resource.
     * اولین رکورد ذخیره شده را دریافت می کند اگر وجود نداشت با متن خطا به صفحه اصلی می رود در غیر این صورت  به ویو برای ویرایش ارسال می کند
     * @param \App\Models\AboutUs $aboutUs مدل درباره ما برای نمایش داده در فرم ویرایش 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(AboutUs $aboutUs)
    {
        $aboutUs = AboutUs::first();
        if (!$aboutUs) {
            return redirect()->route('about-us.index')->with('error', 'اطلاعات یافت نشد.');
        }
        return view('about.edit', compact('aboutUs'));
    }
    
    /**
     * Update the specified resource in storage.
     * 
     * درخواست های کاربر را دریافت و اعتبار سنجی می کند و رکورد را ویرایش می کند
     * @param \Illuminate\Http\Request $request اعتبار سنجی داده ها برای ویرایش
     * @param \App\Models\AboutUs $aboutUs مدل درباره ما برای ویرایش داده  
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, AboutUs $aboutUs)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string'
        ]);
        try{
            $aboutUs->update($validated);
            return redirect()->route('about-us.index')->with('success', ' درباره ما با موفقیت ویرایش شد.');
        } catch(Exception $e){
            Log::error("Error updating about-us". $e->getMessage());
            return redirect()->route('about-us.index')->with('error', 'ویرایش درباره ما با خطا مواجه شد. لطفاً دوباره امتحان کنید.' . (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.'));
        }
    }

}

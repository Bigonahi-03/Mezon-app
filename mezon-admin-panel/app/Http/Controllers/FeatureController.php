<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Slider;
use App\Models\feature;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\FeatureRequest;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     * دریافت تمام ویژگی ها از مدل ویژگی و ارسال ان به ویو برای نمایش
     * @param \App\Models\feature $feature مدل ویژگی 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $features = Feature::get();
        return view('features.index' ,compact('features'));
    }

    /**
     * Show the form for creating a new resource.
     * نمایش ویو ی ایجاد ویژگی
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('features.create');
    }

    /**
     * Store a newly created resource in storage.
     * درخواست ها را پس از اعتبار سنجی دریافت میکند و یک رکورد جدید در جدول ویژگی ها ذخیره میکند
     * @param \App\Models\feature $feature مدل ویژگی 
     * @param \App\Http\Requests\FeatureRequest 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FeatureRequest $request, Feature $feature)
    {
        try{
            $feature::create($request->validated());
            return redirect()->route('features.index')->with('success', ' ویژگی با موفقیت ایجاد شد.');
        }catch(Exception $e){
            Log::error("Error creating feature: ". $e->getMessage());
            return redirect()->route('features.index')->with('error', 'ایجاد ویژگی با خطا مواجه شد. لطفاً دوباره امتحان کنید.' . (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.'));

        }
        
    }


    /**
     * Show the form for editing the specified resource.
     * دریافت ویژگی ساخته شده از مدل ویژگی و ارسال ان به ویو برای ویرایش
     * @param \App\Models\feature $feature  مدل ویژگی 
     * @return \Illuminate\View\View
     */
    public function edit(Feature $feature)
    {
        return view('features.edit', compact('feature'));
    }

    /**
     * Update the specified resource in storage.
     * درخواست های کاربر را بعد از اعتبار سنجی دیافت می کند و ان رکورد را ویرایش می کند
     * @param \App\Models\feature $feature مدل ویژگی 
     * @param \App\Http\Requests\FeatureRequest 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FeatureRequest $request, Feature $feature)
    {
        try {
            $feature->update($request->validated()); 
            return redirect()->route('features.index')->with('success', ' ویژگی با موفقیت ویرایش شد.');
        } catch(Exception $e){
            Log::error("Error updating feature: ". $e->getMessage());
            return redirect()->route('features.edit')->with('error', 'ویرایش ویژگی با خطا مواجه شد. لطفاً دوباره امتحان کنید.' . (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * ویژگی مشخص شده توسط کاربر را حذف میکند
     * @param \App\Models\feature $feature مدل ویژگی برای حذف داده را دریافت می کند
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Feature $feature)
    {
        try {
            $feature->delete();
            return redirect()->route('features.index')->with('success', ' ویژگی با موفقیت حذف شد.');
        } catch(Exception $e){
            Log::error("Error deleting feature: ". $e->getMessage());
            return redirect()->route('features.index')->with('error', 'حذف ویژگی با خطا مواجه شد. لطفاً دوباره امتحان کنید.' . (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.'));
        }
    }
}

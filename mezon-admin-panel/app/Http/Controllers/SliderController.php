<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Slider;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\SliderRequest;



class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     * تمام اسلایدر ها را از جدول اسلایدر ها دریافت می کند به و در متغیر اسلایدرها به ویو می ارسال
     * @return \Illuminate\View\View
     */
    public function index(){
        $sliders = Slider::get(); //نما
        return view('sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     * 
     * ویو ی ساخت اسلایدر را نمایش می دهد
     * @return \Illuminate\View\View
     */
    public function create(){
        return view('sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     * درخواست ها را پس از اعتبار سنجی دریافت می کند و یک رکورد جدید در جدول اسلایدر ها ذخیره می کند
     * @param \App\Http\Requests\SliderRequest $request اعتبار سنجی داده ها برای ذخیره
     * @param \App\Models\Slider $slider مدل اسلایدر برای ساخت یک رکورد جدید   
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SliderRequest $request, Slider $slider){

        try {
            $slider->create($request->validated());
            return redirect()->route('sliders.index')->with('success', 'اسلایدر با موفقیت ایجاد شد');
        } catch (Exception $e) {
            // ایجاد لاگ در صورت خطا در ذخیره
            Log::error('Error creating slider: ' . $e->getMessage());
            return redirect()->route('sliders.index')->with('error', 'ایجاد اسلایدر با خطا مواجه شد. لطفاً دوباره امتحان کنید.'. (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.'));
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     * رکورد های ذخیره شده را دریافت می کند و به ویو برای ویرایش ارسال می کند
     * @param \App\Models\Slider $slider مدل اسلایدر برای نمایش داده در فرم ویرایش 
     * @return \Illuminate\View\View
     */
    public function edit(Slider $slider){
        return view('sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     * درخواست های کاربر را بعد از اعتبار سنجی دریافت می کند و ان رکورد را ویرایش می کند
     * @param \App\Http\Requests\SliderRequest $request اعتبار سنجی داده ها برای ویرایش
     * @param \App\Models\Slider $slider مدل اسلایدر برای ویرایش داده  
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SliderRequest $request, Slider $slider){
        try {
            $slider->update($request->validated());
        
            return redirect()->route('sliders.index')->with('success', 'اسلایدر با موفقیت ویرایش شد');
        } catch (Exception $e) {
            
            // ایجاد لاگ در صورت خطا در ذخیره
            Log::error('Error editing slider: ' . $e->getMessage());
            return redirect()->route('sliders.index')->with('error', 'ویرایش اسلایدر با خطا مواجه شد. لطفاً دوباره امتحان کنید.'. (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * اسلایدر مشخص شده توسط کاربر را حذف می کند
     * @param \App\Models\Slider $slider مدل اسلایدر برای حذف داده را دریافت می کند
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Slider $slider){
        try {
            $slider->delete();
            return redirect()->route('sliders.index')->with('success', 'اسلایدر با موفقیت حذف شد');
        } catch (Exception $e) {
            // ایجاد لاگ در صورت خطا در حذف
            Log::error('Error deleting slider: ' . $e->getMessage());
            return redirect()->route('sliders.index')->with('error', 'حذف اسلایدر با خطا مواجه شد. لطفاً دوباره امتحان کنید.'. (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.'));
        }
    }
}

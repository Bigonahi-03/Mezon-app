<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
/**
 * Display a listing of the resource.
 * دریافت دسته‌بندی‌های اصلی همراه با زیرمجموعه‌هایشان و ارسال به ویو برای نمایش
 * @return \Illuminate\View\View
 */
public function index()
{
    // دریافت دسته‌بندی‌های اصلی (parent_id برابر با null) همراه با زیرمجموعه‌هایشان
    $categories = Category::with('children')->whereNull('parent_id')->get();
    return view('categories.index', compact('categories'));
}

    /**
     * Show the form for creating a main category.
     * ویو ساخت دسته بندی اصلی را نمایش میده
     * @return \Illuminate\View\View
     */
    public function createMain()
    {
        return view('categories.create_main');
    }

    /**
     * Show the form for creating a new subcategory.
     * ویو ساخت دسته بندی فرعی را نمایش میده
     * @param \App\Models\Category $parent مدل دسته بندی وارد که زیر مجموعه برای ان ساخته می شود
     * @return \Illuminate\View\View
     */
    public function createSub(Category $parent)
    {
        return view('categories.create_sub', compact('parent'));
    }

    /**
     * Store a newly created resource in storage.
     * درخواست ها را پس از اعتبار سنجی دریافت می کند و یک رکورد جدید در جدول دسته بندی ها ذخیره می کند
     * @param \App\Http\Requests\CategoryRequest $request اعتبار سنجی داده ها برای ذخیره
     * @param \App\Models\Category $category مدل دسته بندی برای ساخت یک رکورد جدید   
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request, Category $category)
    {

        try {
            $category->create($request->validated());
            return redirect()->route('category.index')->with('success', 'دسته بندی با موفقیت ایجاد شد');
        } catch (Exception $e) {
            Log::error("Error category create" . $e->getMessage());
            return redirect()->route('category.index')->with('error', 'ایجاد دسته بندی با خطا مواجه شد. لطفاً دوباره امتحان کنید.' . (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.'));
        }
    }


    /**
     * Show the form for editing the specified main category.
     * ویو ویرایش دسته بندی اصلی را نمایش میده
     * @param \App\Models\Category $category مدل دسته بندی وارد که زیر مجموعه برای ان ویرایش می شود
     * @return \Illuminate\View\View
     */
    public function editMain(Category $category)
    {
        return view('categories.edit_main', compact('category'));
    }

    /**
     * Show the form for editing the specified subcategory.
     * ویو ویرایش دسته بندی فرعی را نمایش میده
     * @param \App\Models\Category $category مدل دسته بندی وارد که زیر مجموعه برای ان ساخته می شود
     * @return \Illuminate\View\View
     */
    public function editSub(Category $category)
    {
        // دریافت زیر مجموعه های دسته بندی اصلی
        $parentCategory = $category->parent;
        return view('categories.edit_sub', compact('category', 'parentCategory'));
    }



    /**
     * Update the specified resource in storage.
     * درخواست ها را پس از اعتبار سنجی دریافت می کند و رکورد را در جدول دسته بندی ها ویرایش می کند
     * @param \App\Http\Requests\CategoryRequest $request اعتبار سنجی داده ها برای ویرایش
     * @param \App\Models\Category $category مدل دسته بندی برای ویرایش رکورد    
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $category->update($request->validated());
            return redirect()->route('category.index')->with('success', 'دسته بندی با موفقیت ویرایش شد');
        } catch (Exception $e) {
            Log::error("Error category edit" . $e->getMessage());
            return redirect()->route('category.index')->with('error', 'ویرایش دسته بندی با خطا مواجه شد. لطفاً دوباره امتحان کنید.' . (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * دسته بندی مشخص شده توسط کاربر را حذف می کند
     * @param \App\Models\Slider $slider مدل دسته بندی برای حذف داده را دریافت می کند
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return redirect()->route('category.index')->with('success', ' دسته بندی با موفقیت حذف شد.');
        } catch (Exception $e) {
            Log::error("Error deleting category: " . $e->getMessage());
            return redirect()->route('category.index')->with('error', 'حذف دسته بندی با خطا مواجه شد. لطفاً دوباره امتحان کنید.' . (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.'));
        }
    }
}

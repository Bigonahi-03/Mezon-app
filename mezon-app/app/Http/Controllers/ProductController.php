<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Nette\Utils\Random;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

/**
 * Display the specified product details.
 * نمایش مشخصات محصول خاص به همراه تصاویر و محصولات تصادفی
 *
 * @param \App\Models\Product $product مدل محصول انتخاب‌شده
 * @return \Illuminate\View\View
 */
public function show(Product $product)
{
    // دریافت تمام تصاویر مرتبط با محصول
    $images = $product->images;

    // دریافت چهار محصول تصادفی که موجودی داشته باشند و تکراری نباشند
    $randomProducts = Product::status()->where('quantity', '>', 0)->where('id', '!=', $product->id)->get()->random(4);

    // ارسال محصول، تصاویر، و محصولات تصادفی به ویو
    return view('products.product', compact('product', 'images', 'randomProducts'));
}

/**
 * Display the menu page with categories and related products.
 * نمایش صفحه منو همراه با دسته‌بندی‌ها و محصولات مرتبط
 * و فلیتر جستجو، دسته بندی فرعی و مرتب سازی محصولات
 *
 * @return \Illuminate\View\View
 */
public function menu(Request $request)
{
    $search = $request->query('search');
    $tab = $request->query('tab', 'all');
    $category = $request->query('category');

    //دریافت تمام دسته‌بندی‌ها فعال همراه با زیردسته‌ها
    $mainCategories = Category::status()->whereNull('parent_id')->get();

    //دریافت تمام محصولات فعال همراه با جستجو به صورت صفحه بندی
    $products = Product::search($request->search)->status()->sortBy()->paginate(9, ['*'], 'all_page');

    //ارایه ذخیره محصولات بر اساس دسته بندی
    $productByMainCategory = [];

    //دریافت محصولات برای هر دسته‌بندی اصلی
    foreach ($mainCategories as $mainCategory) {
        $subCategory = $mainCategory->children;
        $categoryIds = $mainCategory->children->pluck('id')->toArray();

        $productByMainCategory[$mainCategory->slug] = Product::status()
            ->search($request->search)
            ->whereIn('category_id', $categoryIds)
            ->category()
            ->sortBy()
            ->orderBy('created_at', 'desc')
            ->paginate(9, ['*'], $mainCategory->slug . '_page');
    }

    return view('products.menu', compact('products', 'mainCategories', 'subCategory', 'productByMainCategory', 'search', 'tab'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

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

    // دریافت ۴ محصول تصادفی که:
    // ۱. فعال باشند (status = 1)
    // ۲. موجودی داشته باشند (quantity > 0)
    // ۳. محصول فعلی در میان آن‌ها نباشد
    $randomProducts = Product::where('status', 1)
        ->where('quantity', '>', 0)
        ->where('id', '!=', $product->id)
        ->get()
        ->random(4);

    // ارسال محصول، تصاویر، و محصولات تصادفی به ویو
    return view('products.product', compact('product', 'images', 'randomProducts'));
}

/**
 * Display the menu page with categories and related products.
 * نمایش صفحه منو همراه با دسته‌بندی‌ها و محصولات مرتبط
 *
 * @return \Illuminate\View\View
 */
public function menu(Request $request)
{
    $search = $request->query('search');
    $tab = $request->query('tab', 'all');

    $products = Product::where('status', 1)
        ->when($search, function($query) use ($search) {
            return $query->search($search);
        })
        ->paginate(12, ['*'], 'all_page');

    $mainCategories = Category::with('children')
        ->whereNull('parent_id')
        ->where('status', '1')
        ->get();

    $productByMainCategory = [];

    foreach ($mainCategories as $mainCategory) {
        $categoryIds = $mainCategory->children->pluck('id')->toArray();

        $productByMainCategory[$mainCategory->slug] = Product::whereIn('category_id', $categoryIds)
            ->where('status', 1)
            ->when($search, function($query) use ($search) {
                return $query->search($search);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(2, ['*'], $mainCategory->slug . '_page');
    }

    return view('products.menu', compact('products', 'mainCategories', 'productByMainCategory', 'search', 'tab'));
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

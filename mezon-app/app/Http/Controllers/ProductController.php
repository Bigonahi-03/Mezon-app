<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
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

    // دریافت ۴ محصول تصادفی 
    $randomProducts = Product::where('status', 1)->where('quantity', '>', 0)->where('id', '!=', $product->id)->get()->random(4);

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
    $searchQuery = $request->search;
    $mainCategories = Category::with('children')->whereNull('parent_id')->where('status', '1')->get();
    
    // Base query for all products
    $productsQuery = Product::where('status', 1)
        ->search($searchQuery)
        ->when($request->sort, function($query, $sort) {
            switch($sort) {
                case 'price_desc': return $query->orderBy('price', 'desc');
                case 'price_asc': return $query->orderBy('price', 'asc');
                case 'popular': return $query->orderBy('sales_count', 'desc');
                case 'discount': return $query->where('discount', '>', 0);
                default: return $query->latest();
            }
        }, function($query) {
            return $query->latest();
        });

    // Get all active products
    $products = $productsQuery->paginate(9, ['*'], 'تمام_دسته_بندی_ها');

    // Get products by main category
    $productByMainCategory = [];
    foreach ($mainCategories as $mainCategory) {
        $categoryIds = $mainCategory->children->pluck('id')->toArray();
        $slug = 'دسته_بندی_' . str_replace(' ', '_', $mainCategory->name);
        
        $productByMainCategory[$mainCategory->id] = $productsQuery
            ->whereIn('category_id', $categoryIds)
            ->paginate(9, ['*'], $slug);
    }

    return view('products.menu', compact('products', 'mainCategories', 'productByMainCategory', 'searchQuery'));
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

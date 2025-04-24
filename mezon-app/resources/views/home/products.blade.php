@php
    use App\Models\Category;
    use App\Models\Product;

    // دریافت دسته‌بندی‌های اصلی همراه با زیرمجموعه‌ها
    $mainCategories = Category::with('children')->where('status', 1)->whereNull('parent_id')->limit(4)->get();

    // آرایه‌ای برای ذخیره محصولات بر اساس دسته‌بندی‌شان
    $productsByCategory = [];

    foreach ($mainCategories as $mainCategory) {
        $childIds = $mainCategory->children->pluck('id')->toArray();

        foreach ($mainCategory->children as $child) {
            $productsByMainCategory[$mainCategory->id] = Product::whereIn('category_id', $childIds)
                ->where('status', 1)
                ->where('quantity', '>', 0)
                ->orderBy('created_at', 'desc')
                ->limit(4) 
                ->get();
        }
    }
@endphp



<section class="food_section">
    {{-- اولین دسته‌بندی به صورت پیش‌فرض فعال --}}
    <div class="container mb-5" x-data="{ tab: {{ $mainCategories->first()->id ?? 'null' }} }">
        <div class="heading_container heading_center">
            <h2>جدیدترین محصولات</h2>
        </div>

        <ul class="filters_menu">
            {{-- نمایش تمام دسته‌بندی‌های اصلی --}}
            @foreach ($mainCategories as $mainCategory)
                <li :class="tab === {{ $mainCategory->id }} ? 'active' : ''" @click="tab = {{ $mainCategory->id }}">
                    {{ $mainCategory->name }}
                </li>
            @endforeach
        </ul>

        <div class="filters-content">
            {{-- ساخت تب‌ها برای دسته‌بندی‌های اصلی --}}
            @foreach ($mainCategories as $mainCategory)
                <div x-show="tab === {{ $mainCategory->id }}">
                    <div class="row grid">
                        {{-- محصولات را بر اساس دسته بندی  --}}
                        @foreach ($productsByMainCategory[$mainCategory->id] ?? [] as $product)
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <x-product-card :product="$product" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>

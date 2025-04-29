<div class="card">
    <div class="card-body">
        <h5 class="card-title">دسته‌بندی‌ها</h5>
        <div class="list-group">
            <a href="{{ route('products.menu') }}" class="list-group-item list-group-item-action {{ $defaultTab === 'همه' ? 'active' : '' }}">
                همه
            </a>
            @foreach ($mainCategories as $category)
                <a href="{{ route('products.menu', ['category' => $category->slug]) }}" 
                   class="list-group-item list-group-item-action {{ $defaultTab === $category->slug ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <h5 class="card-title mt-4">مرتب‌سازی</h5>
        <div class="list-group">
            <a href="{{ route('products.menu', ['sort' => 'price_desc']) }}" class="list-group-item list-group-item-action">
                گران‌ترین
            </a>
            <a href="{{ route('products.menu', ['sort' => 'price_asc']) }}" class="list-group-item list-group-item-action">
                ارزان‌ترین
            </a>
            <a href="{{ route('products.menu', ['sort' => 'popular']) }}" class="list-group-item list-group-item-action">
                پرفروش‌ترین
            </a>
            <a href="{{ route('products.menu', ['sort' => 'discount']) }}" class="list-group-item list-group-item-action">
                تخفیف‌دار
            </a>
        </div>
    </div>
</div>
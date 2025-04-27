<div class="filter-list">
    <div class="form-label">دسته‌بندی</div>
    <ul class="list-unstyled">
        @foreach($mainCategories as $category)
            <li class="my-2 cursor-pointer {{ $defaultTab == $category->id ? 'filter-list-active' : '' }}"
                @click="changeTab({{ $category->id }})">
                {{ $category->name }}
            </li>
        @endforeach
    </ul>
</div>

<hr />

<div>
    <label class="form-label">مرتب‌سازی</label>
    <div class="form-check my-2">
        <input class="form-check-input" type="radio" name="sort" value="price_desc" 
            {{ request('sort') == 'price_desc' ? 'checked' : '' }}>
        <label class="form-check-label">بیشترین قیمت</label>
    </div>
    <div class="form-check my-2">
        <input class="form-check-input" type="radio" name="sort" value="price_asc"
            {{ request('sort') == 'price_asc' ? 'checked' : '' }}>
        <label class="form-check-label">کمترین قیمت</label>
    </div>
    <div class="form-check my-2">
        <input class="form-check-input" type="radio" name="sort" value="popular"
            {{ request('sort') == 'popular' ? 'checked' : '' }}>
        <label class="form-check-label">پرفروش‌ترین</label>
    </div>
    <div class="form-check my-2">
        <input class="form-check-input" type="radio" name="sort" value="discount"
            {{ request('sort') == 'discount' ? 'checked' : '' }}>
        <label class="form-check-label">با تخفیف</label>
    </div>
</div>
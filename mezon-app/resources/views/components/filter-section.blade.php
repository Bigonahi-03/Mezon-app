@props(['isMobile' => false, 'mainCategories'])

<div class="{{ $isMobile ? 'col-12 d-lg-none mb-3' : 'd-none d-lg-block' }}">
    @if ($isMobile)
        <div class="collapse mt-3" id="mobileFilter">
            <div class="card card-body">
    @endif

    <div class="filter-list {{ $isMobile ? 'mb-3' : '' }}">
        @if (request()->has('tab') && in_array(request()->tab, $mainCategories->pluck('slug')->toArray()))
            <h6 class="form-label">دسته‌بندی
                @if (request()->has('category'))
                    <i @click="removeFilter('category')" class="bi bi-x text-danger fs-5 cursor-pointer"></i>
                @endif
            </h6>
            <ul class="">
                @foreach ($mainCategories->where('slug', request()->tab)->first()->children as $subCategory)
                    <li class="my-2 cursor-pointer {{ request()->get('category') === makeSlug($subCategory->name) ? 'filter-list-active' : '' }}"
                        @click="filter('category', '{{ makeSlug($subCategory->name) }}')">{{ $subCategory->name }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <hr />

    <div>
        <label class="form-label">مرتب‌سازی</label>
        <div class="form-check my-2">
            <input class="form-check-input" type="radio" name="sort_{{ $isMobile ? 'mobile' : 'desktop' }}" />
            <label class="form-check-label">بیشترین قیمت</label>
        </div>
        <div class="form-check my-2">
            <input class="form-check-input" type="radio" name="sort_{{ $isMobile ? 'mobile' : 'desktop' }}" checked />
            <label class="form-check-label">کمترین قیمت</label>
        </div>
        <div class="form-check my-2">
            <input class="form-check-input" type="radio" name="sort_{{ $isMobile ? 'mobile' : 'desktop' }}" />
            <label class="form-check-label">پرفروش‌ترین</label>
        </div>
        <div class="form-check my-2">
            <input class="form-check-input" type="radio" name="sort_{{ $isMobile ? 'mobile' : 'desktop' }}" />
            <label class="form-check-label">با تخفیف</label>
        </div>
    </div>

    @if ($isMobile)
</div>
</div>
@endif
</div>

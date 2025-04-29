@extends('layouts.master')

@section('title', 'Menu Page')

@section('script')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('menu', (initialTab = 'all') => ({
            search: '{{ request()->get('search') }}',
            tab: localStorage.getItem('activeTab') || initialTab,
            currentUrl: '{{ url()->current() }}',
            params: new URLSearchParams(location.search),

            init() {
                this.$watch('tab', (value) => {
                    localStorage.setItem('activeTab', value);

                    // حذف همه پارامترهای page وقتی تب عوض میشه
                    for (let [key] of this.params.entries()) {
                        if (key.endsWith('_page') || key === 'all_page') {
                            this.params.delete(key);
                        }
                    }

                    // اضافه کردن پارامتر جدید tab برای تشخیص تب فعال
                    this.params.set('tab', value);

                    // رفتن به آدرس جدید با پارامترهای به‌روز
                    window.location.href = this.currentUrl + '?' + this.params.toString();
                });
            },

            filter(type, value) {
                this.params.set(type, value);
                this.params.delete('all_page');
                for (let [key] of this.params.entries()) {
                    if (key.endsWith('_page')) {
                        this.params.delete(key);
                    }
                }
                window.location.href = this.currentUrl + '?' + this.params.toString();
            },

            removeFilter(type) {
                this.params.delete(type);
                this.params.delete('all_page');
                for (let [key] of this.params.entries()) {
                    if (key.endsWith('_page')) {
                        this.params.delete(key);
                    }
                }
                window.location.href = this.currentUrl + '?' + this.params.toString();
            }
        }));
    });
</script>
@endsection

@section('content')
<section class="food_section layout_padding">
    <div class="container" x-data="menu('{{ request()->get('tab', 'all') }}')">

        <div class="row align-items-center">
            <div class="col-lg-8 col-12 order-1 order-lg-2">
                <ul class="filters_menu pb-2">
                    <li :class="tab === 'all' ? 'active' : ''" @click="tab = 'all'">
                        همه
                    </li>
                    {{-- نمایش تمام دسته‌بندی‌های اصلی --}}
                    @foreach ($mainCategories as $mainCategory)
                        <li :class="tab === '{{ $mainCategory->slug }}' ? 'active' : ''"
                            @click="tab = '{{ $mainCategory->slug }}'">
                            {{ $mainCategory->name }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-4 col-12 order-2 order-lg-1">
                <label class="form-label">جستجو
                    @if (request()->has('search'))
                        <i @click="removeFilter('search')" class="bi bi-x text-danger fs-5 cursor-pointer"></i>
                    @endif
                </label>
                <div class="input-group mb-3">
                    <input type="text" x-model="search" class="form-control" placeholder="نام محصول ..." />
                    <button @click="filter('search', search)" class="input-group-text">
                        <i class="bi bi-search"></i>
                    </button>
                    <button class="input-group-text d-lg-none ms-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#mobileFilter">
                        <i class="bi bi-filter"></i>
                    </button>
                </div>
                @if (request()->has('search'))
                    <div class="alert alert-info py-0">
                        <p class="mb-0">جستجوی: {{ request()->get('search') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-lg-3">
                {{-- فیلتر در دسکتاپ --}}
                <div class="d-none d-lg-block">
                    <div class="filter-list">
                        <div class="form-label">دسته‌بندی</div>
                        <ul class="list-unstyled">
                            <li class="my-2 cursor-pointer filter-list-active">پیتزا</li>
                            <li class="my-2 cursor-pointer">برگر</li>
                            <li class="my-2 cursor-pointer">پیش‌غذا</li>
                            <li class="my-2 cursor-pointer">نوشیدنی</li>
                        </ul>
                    </div>

                    <hr />

                    <div>
                        <label class="form-label">مرتب‌سازی</label>
                        <div class="form-check my-2">
                            <input class="form-check-input" type="radio" name="sort_desktop" />
                            <label class="form-check-label">بیشترین قیمت</label>
                        </div>
                        <div class="form-check my-2">
                            <input class="form-check-input" type="radio" name="sort_desktop" checked />
                            <label class="form-check-label">کمترین قیمت</label>
                        </div>
                        <div class="form-check my-2">
                            <input class="form-check-input" type="radio" name="sort_desktop" />
                            <label class="form-check-label">پرفروش‌ترین</label>
                        </div>
                        <div class="form-check my-2">
                            <input class="form-check-input" type="radio" name="sort_desktop" />
                            <label class="form-check-label">با تخفیف</label>
                        </div>
                    </div>
                </div>

                {{-- collapse فیلتر در موبایل --}}
                <div class="col-12 d-lg-none mb-3">

                    <div class="collapse mt-3" id="mobileFilter">
                        <div class="card card-body">
                            <div class="filter-list mb-3">
                                <div class="form-label">دسته‌بندی</div>
                                <ul class="list-unstyled">
                                    <li class="my-2 cursor-pointer filter-list-active">پیتزا</li>
                                    <li class="my-2 cursor-pointer">برگر</li>
                                    <li class="my-2 cursor-pointer">پیش‌غذا</li>
                                    <li class="my-2 cursor-pointer">نوشیدنی</li>
                                </ul>
                            </div>

                            <hr />

                            <div>
                                <label class="form-label">مرتب‌سازی</label>
                                <div class="form-check my-2">
                                    <input class="form-check-input" type="radio" name="sort_mobile" />
                                    <label class="form-check-label">بیشترین قیمت</label>
                                </div>
                                <div class="form-check my-2">
                                    <input class="form-check-input" type="radio" name="sort_mobile" checked />
                                    <label class="form-check-label">کمترین قیمت</label>
                                </div>
                                <div class="form-check my-2">
                                    <input class="form-check-input" type="radio" name="sort_mobile" />
                                    <label class="form-check-label">پرفروش‌ترین</label>
                                </div>
                                <div class="form-check my-2">
                                    <input class="form-check-input" type="radio" name="sort_mobile" />
                                    <label class="form-check-label">با تخفیف</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-lg-9">
                {{-- تب همه محصولات --}}
                <div x-show="tab === 'all'">
                    @if ($products->isEmpty())
                        <div class="d-flex justify-content-center align-items-center" style="height: 500px;">
                            <h5>محصولی برای نمایش وجود ندارد!</h5>
                        </div>
                    @else
                        <div class="row grid">
                            @foreach ($products as $product)
                                <div class="col-sm-6 col-lg-4 col-12">
                                    <x-product-card :product="$product" />
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            {{ $products->withQueryString()->links('layouts.paginate', ['pageName' => 'all_page']) }}
                        </div>
                    @endif
                </div>
                {{-- تب محصولات براساس دسته‌بندی‌های اصلی --}}

                @foreach ($mainCategories as $mainCategory)
                    <div x-show="tab === '{{ $mainCategory->slug }}'">
                        @if ($productByMainCategory[$mainCategory->slug]->isEmpty())
                            <div class="d-flex justify-content-center align-items-center" style="height: 500px;">
                                <h5>محصولی برای نمایش وجود ندارد!</h5>
                            </div>
                        @else
                            <div class="row grid">
                                @foreach ($productByMainCategory[$mainCategory->slug] as $product)
                                    <div class="col-sm-6 col-lg-4 col-12">
                                        <x-product-card :product="$product" />
                                    </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                {{ $productByMainCategory[$mainCategory->slug]->withQueryString()->links('layouts.paginate', ['pageName' => $mainCategory->slug . '_page']) }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection

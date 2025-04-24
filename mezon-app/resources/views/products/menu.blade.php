@extends('layouts.master')

@section('title', 'Menu Page')

@section('script')
<script type="text/javascript">
    document.addEventListener('alpine:init', () => {
        Alpine.data('filter', () => ({
            search: '',
            currentUrl: '{{ url()->current() }}',
            filter(type, value) {
                console.log(this.currentUrl );
            }
        }));
    });
</script>
@endsection

@section('content')
    <section class="food_section layout_padding">
        <div class="container" x-data="{tab : 0}" x-data="filter" >
           
            <div class="row align-items-center" >
                <div class="col-lg-8 col-12 order-1 order-lg-2">
                    <ul class="filters_menu pb-2">
                         <li :class="tab === 0 ? 'active' : ''" @click="tab = 0">
                            همه
                        </li>
                        {{-- نمایش تمام دسته‌بندی‌های اصلی --}}
                        @foreach ($mainCategories as $mainCategory)
                            <li :class="tab === {{ $mainCategory->id }} ? 'active' : ''"
                                @click="tab = {{ $mainCategory->id }}">
                                {{ $mainCategory->name }}
                            </li>
                        @endforeach 
                    </ul>
                </div>
                <div class="col-lg-4 col-12 order-2 order-lg-1">
                    <label class="form-label">جستجو</label>
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
                    <div x-show="tab === 0">
                        <div class="row grid">
                            @foreach ($products as $product)
                                <div class="col-sm-6 col-lg-4 col-12">
                                    <x-product-card :product="$product" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- تب دسته‌بندی‌های اصلی --}}
                    @foreach ($mainCategories as $mainCategory)
                        <div x-show="tab === {{ $mainCategory->id }}">
                            <div class="row grid">
                                @foreach ($productByMainCategory[$mainCategory->id] ?? [] as $product)
                                    <div class="col-sm-6 col-lg-4 col-12">
                                        <x-product-card :product="$product" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <nav class="d-flex justify-content-center mt-5">
                    <ul class="pagination">
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        </div>
    </section>



@endsection





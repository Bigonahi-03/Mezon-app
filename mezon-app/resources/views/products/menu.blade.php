@php
    $defaultTab = 0;
    foreach ($mainCategories as $category) {
        $pageParam = 'دسته_بندی_' . str_replace(' ', '_', $category->name);
        if (request()->has($pageParam)) {
            $defaultTab = $category->id;
            break;
        }
    }
@endphp
@extends('layouts.master')

@section('title', 'Menu Page')

@section('script')
    <script type="text/javascript">
        document.addEventListener('alpine:init', () => {
            Alpine.data('menuPage', () => ({
                // State
                search: '{{ $searchQuery ?? '' }}',
                activeTab: {{ $defaultTab }},
                currentUrl: '{{ url()->current() }}',
                sortOption: '{{ request()->sort ?? '' }}',
                mobileFiltersOpen: false,

                // Initialize component
                init() {
                    // Watch for search changes with debounce
                    this.$watch('search', (value) => {
                        if (value.length > 2 || value.length === 0) {
                            this.applyFilters();
                        }
                    });

                    // Watch for sort option changes
                    this.$watch('sortOption', () => {
                        this.applyFilters();
                    });
                },

                // Change active tab
                changeTab(tabId) {
                    this.activeTab = tabId;
                    this.applyFilters();
                },

                // Toggle mobile filters
                toggleMobileFilters() {
                    this.mobileFiltersOpen = !this.mobileFiltersOpen;
                },

                // Apply all filters and update URL
                applyFilters() {
                    const url = new URL(this.currentUrl);

                    // Clear all category params
                    @foreach ($mainCategories as $category)
                        url.searchParams.delete('دسته_بندی_' +
                            '{{ str_replace(' ', '_', $category->name) }}');
                    @endforeach

                    // Set active category param if not "All"
                    if (this.activeTab > 0) {
                        const category = @json($mainCategories->firstWhere('id', $defaultTab));
                        if (category) {
                            url.searchParams.set('دسته_بندی_' + category.name.replace(' ', '_'), '1');
                        }
                    }

                    // Set search param if exists
                    if (this.search) {
                        url.searchParams.set('search', this.search);
                    } else {
                        url.searchParams.delete('search');
                    }

                    // Set sort param if exists
                    if (this.sortOption) {
                        url.searchParams.set('sort', this.sortOption);
                    } else {
                        url.searchParams.delete('sort');
                    }

                    // Update URL without page reload if only tab changed
                    if (window.history && window.history.replaceState) {
                        window.history.replaceState(null, null, url.toString());
                    }

                    // Reload page to apply filters
                    window.location.href = url.toString();
                },

                // Reset all filters
                resetFilters() {
                    this.search = '';
                    this.activeTab = 0;
                    this.sortOption = '';
                    this.applyFilters();
                },

                // Helper to check if any filters are active
                get filtersActive() {
                    return this.search || this.activeTab > 0 || this.sortOption;
                }
            }));
        });
    </script>
@endsection

@section('content')
    <section class="food_section layout_padding" x-data="filter">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-12 order-1 order-lg-2">
                    {{-- Category Tabs --}}
                    <ul class="filters_menu pb-2">
                        <li :class="activeTab === 0 ? 'active' : ''" @click="changeTab(0)">
                            همه
                        </li>
                        @foreach ($mainCategories as $mainCategory)
                            <li :class="activeTab === {{ $mainCategory->id }} ? 'active' : ''"
                                @click="changeTab({{ $mainCategory->id }})">
                                {{ $mainCategory->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-lg-4 col-12 order-2 order-lg-1">
                    {{-- Search Filter --}}
                    <label class="form-label">جستجو</label>
                    <div class="input-group mb-3">
                        <input type="text" x-model="search" name="search" class="form-control"
                            placeholder="نام محصول ..." value="{{ $searchQuery ?? '' }}" />
                        <button @click="filter('search', search)" class="input-group-text">
                            <i class="bi bi-search"></i>
                        </button>
                        <button class="input-group-text d-lg-none ms-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#mobileFilter">
                            <i class="bi bi-filter"></i>
                        </button>
                    </div>

                    @if ($searchQuery)
                        <div class="alert alert-info py-2 px-3 mb-3">
                            نتایج جستجو برای: "<span>{{ $searchQuery }}</span>"
                            <a href="{{ url()->current() }}" class="float-start text-danger">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                {{-- Filters (Desktop) --}}
                <div class="col-sm-12 col-lg-3 d-none d-lg-block">
                    @include('products.partials.filters')
                </div>

                {{-- Products --}}
                <div class="col-sm-12 col-lg-9">
                    @if ($products->isEmpty())
                        <div class="d-flex justify-content-center h-100">
                            <h5 class="align-self-center">محصولی یافت نشد!</h5>
                        </div>
                    @else
                        {{-- All Products --}}
                        <div x-show="activeTab === 0" x-transition>
                            <div class="row grid">
                                @foreach ($products as $product)
                                    <div class="col-sm-6 col-lg-4 col-12 mb-4">
                                        <x-product-card :product="$product" />
                                    </div>
                                @endforeach
                            </div>
                            {{ $products->withQueryString()->links('layouts.paginate') }}
                        </div>

                        {{-- Products by Category --}}
                        @foreach ($mainCategories as $mainCategory)
                            <div x-show="activeTab === {{ $mainCategory->id }}" x-transition>
                                <div class="row grid">
                                    @forelse ($productByMainCategory[$mainCategory->id] ?? [] as $product)
                                        <div class="col-sm-6 col-lg-4 col-12 mb-4">
                                            <x-product-card :product="$product" />
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <p>هیچ محصولی در این دسته‌بندی یافت نشد.</p>
                                        </div>
                                    @endforelse
                                </div>
                                @if (isset($productByMainCategory[$mainCategory->id]))
                                    {{ $productByMainCategory[$mainCategory->id]->withQueryString()->links('layouts.paginate') }}
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>

                {{-- Mobile Filters --}}
                <div class="col-12 d-lg-none">
                    <div class="collapse mt-3" id="mobileFilter">
                        <div class="card card-body">
                            @include('products.partials.filters')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

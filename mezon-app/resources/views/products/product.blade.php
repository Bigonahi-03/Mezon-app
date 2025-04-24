@extends('layouts.master')

@section('title', 'Product')

@section('content')

    <section class="single_page_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="row gy-5">
                        <div class="col-sm-12 col-lg-6">
                            <h3 class="fw-bold mb-4">{{ $product->name }}</h3>
                            @if ($product->quantity < 1)
                                <h5 class="bg-danger badge text-dark fs-5 ">
                                    موجودی ندارد
                                </h5>
                            @else
                            <h5 class="mb-3">
                                @if ($product->is_sale)
                                    <del>{{ number_format($product->price) }}</del>
                                    {{ number_format($product->sale_price) }}
                                    تومان
                                    <div class="text-danger fs-6">
                                        {{ salePercent($product->price, $product->sale_price) }}% تخفیف
                                    </div>
                                @else
                                    {{ number_format($product->price) }}
                                    تومان
                                @endif()
                            </h5>
                            @endif

                            <p>{{ $product->description }}</p>

                            @if ($product->quantity < 1)
                            <a href="#">
                                <button class="btn btn-outline-warning btn-sm d-flex align-items-center gap-2">
                                    <i class="bi bi-bell"></i>
                                    موجود شد به من اطلاع بده
                                </button>
                            </a>
                            @else
                            <form x-data="{ quantity: 1 }" action="#" class="mt-5 d-flex">
                                <button class="btn-add">افزودن به سبد خرید</button>
                                <div class="input-counter ms-4">
                                    <span @click="quantity++" class="plus-btn">
                                        +
                                    </span>
                                    <div class="input-number" x-text="quantity"></div>
                                    <span @click="quantity > 1 && quantity--" class="minus-btn">
                                        -
                                    </span>
                                </div>
                            </form>  
                            @endif
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                                        class="active">
                                    </button>

                                    @foreach ($images as $key => $image)
                                        <button type="button" data-bs-target="#carouselExampleIndicators"
                                            data-bs-slide-to="{{ $key + 1 }}"></button>
                                    @endforeach
                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ imageUrl($product->primary_image) }}" class="d-block w-100"
                                            alt="Primary Image" />
                                    </div>

                                    @foreach ($images as $image)
                                        <div class="carousel-item">
                                            <img src="{{ imageUrl($image->image) }}" class="d-block w-100"
                                                alt="Product Image" />
                                        </div>
                                    @endforeach

                                </div>

                                @foreach ($images as $image)
                                    @if ($image)
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                            <span class="carousel-control-next-icon"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end food section -->
    <hr>
    <section class="food_section my-5">
        <div class="container">
            <div class="row gx-3">
                @foreach ($randomProducts as $randomProduct)
                <div class="col-sm-6 col-lg-3">
                        <div class="box">
                            <div class="img-box">
                                <img class="img-fluid" src="{{ imageUrl($randomProduct->primary_image) }}"
                                    alt="Product image">
                            </div>
                            <div class="detail-box">
                                <h5><a
                                        href="{{ route('products.show', ['product' => $randomProduct->slug]) }}">{{ $randomProduct->name }}</a>
                                </h5>
                                <p>{{ mb_substr($randomProduct->description, 0, 300) }}</p>
                                <div class="options">
                                    <h6>
                                        @if ($randomProduct->is_sale)
                                            <div>
                                                <del>{{ number_format($randomProduct->price) }}</del>
                                                <span class="text-danger">
                                                    {{-- از تابع استفاده کردیم تا درصد تخفیف را نمایش دهد --}}
                                                    ({{ salePercent($randomProduct->price, $randomProduct->sale_price) }}%)
                                                </span>
                                            </div>
                                            {{ number_format($randomProduct->sale_price) }}
                                            تومان
                                        @else
                                            {{ number_format($randomProduct->price) }}
                                            تومان
                                        @endif
                                    </h6>
                                    <div class="d-flex">
                                        <a class="me-2" href="#"><i class="bi bi-cart-fill text-white fs-6"></i></a>
                                        <a href="#"><i class="bi bi-heart-fill text-white fs-6"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
            </div>
        </div>
    </section>
@endsection

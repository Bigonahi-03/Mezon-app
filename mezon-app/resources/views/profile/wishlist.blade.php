@extends('profile.layouts.master')

@section('title', 'Profile | Wishlist')

@section('main')
    <div class="col-md-8 mt-5 mt-md-0">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>محصول</th>
                        <th>نام</th>
                        <th>قیمت</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($wishlist as $item)
                        <tr>
                            <th>
                                <img src="{{ imageUrl($item->product->primary_image) }}" class="rounded" width="100"
                                    alt="{{ $item->product->primary_image }}"></img>
                            </th>
                            <th> 
                                <a href="{{ route('products.show', ['product' => $item->product->slug]) }}">
                                    {{ $item->product->name }}
                                </a>    
                            </th>
                                
                            <th>
                                @if ($item->product->quantity > 0)
                                    {{-- برای محصولات موجود --}}
                                    <h6>
                                        @if ($item->product->is_sale)
                                            <div>
                                                <del>{{ number_format($item->product->price) }}</del>
                                                <span class="text-danger">
                                                    ({{ salePercent($item->product->price, $item->product->sale_price) }}%)
                                                </span>
                                            </div>
                                            {{ number_format($item->product->sale_price) }} تومان
                                        @else
                                            {{ number_format($item->product->price) }} تومان
                                        @endif
                                    </h6>
                                    @else
                                    <h5 class="bg-danger badge text-dark fs-6 m-0">
                                    موجودی ندارد
                                </h5>
                                @endif
                                
                            </th>
                            <th>
                                <a href="{{ route('profile.wishlist.remove', ['product_id' => $item->product->id]) }}" class="btn btn">
                                    حذف
                                </a>
                            </th>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

@endsection

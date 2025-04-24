@extends('layouts.master')
@section('title', 'Products Show')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">نمایش محصولات</h4>
    </div>

    <div class="row mb-5 gy-4">
        {{-- Primary Image --}}
        <div class="d-flex justify-content-center align-items-center text-center" style="min-height: auto;" x-data="imageViewer()">
            <div class="col-md-4">
                    <img src="{{ asset('images/products/' . $product->primary_image) }}" class="rounded" width="300" height="350" alt="primary-image"> 
            </div>
        </div>
        
        {{-- Product Name  --}}
        <div class="col-md-3">
            <label class="form-label">نام</label>
            <input disabled value="{{ $product->name }}" class="form-control" />
        </div>

        {{-- Product Category  --}}
        <div class="col-md-3">
            <label class="form-label">دسته بندی</label>
            <input disabled value="{{ $product->category->name }}" class="form-control" />
        </div>
        
        {{-- Product Status  --}}
        <div class="col-md-3">
            <label class="form-label">وضعیت</label>
            <input disabled value="{{ $product->status ? 'فعال' : 'غیر فعال' }}" class="form-control" />
        </div>

        {{-- Product Price  --}}
        <div class="col-md-3">
            <label class="form-label">قیمت</label>
            <input disabled value="{{ number_format($product->price) }}" class="form-control" />
        </div>

        {{-- Product Quantity  --}}
        <div class="col-md-3">
            <label class="form-label">تعداد</label>
            <input disabled value="{{ $product->quantity }}" class="form-control" />
        </div>

        {{-- Product Sale Price  --}}
        <div class="col-md-3">
            <label class="form-label">قیمت حراج شده</label>
            <input disabled value="{{ $product->sale_price }}" class="form-control" />
        </div>

        {{-- Product Auction start date  --}}
        <div class="col-md-3">
            <label class="form-label">تاریخ شروع حراجی</label>
            <input disabled value="{{ $product->date_on_sale_from != null ? getJalaliDate($product->date_on_sale_from) : '' }}" class="form-control" />
        </div>

        {{-- Product Auction end date  --}}
        <div class="col-md-3">
            <label class="form-label">تاریخ پایان حراجی</label>
            <input disabled value="{{ $product->date_on_sale_from != null ? getJalaliDate($product->date_on_sale_to) : '' }}" class="form-control" />
        </div>

        {{-- Product Featured  --}}
        <div class="col-md-3">
            <label class="form-label">حالت</label>
            <input disabled value="{{ $product->is_featured ? 'ویژه' : 'عادی ' }}" class="form-control" />
        </div>

        {{-- Product Description  --}}
        <div class="col-md-12">
            <label class="form-label">توضیحات</label>
            <textarea disabled class="form-control" rows="5"> {{ $product->description }} </textarea>
        </div>

        {{-- Product Imags  --}}
        <div class="col-md-12">
            <label class="form-label">تصاویر دیگر </label>
            @foreach ($product->images as $image)
            <img src="{{ asset('images/products/' . $image->image) }}" class="rounded" width="200"  alt="images"> 
            @endforeach
        </div>
    </div>
@endsection

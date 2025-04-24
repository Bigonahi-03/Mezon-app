@extends('layouts.master')

@section('title', 'سایزبندی محصول')

@section('content')
    <h4 class="fw-bold mb-4">سایزبندی محصول: {{ $product->name }}</h4>

    <div class="card ">
        <div class="card-header d-sm-flex">
            <div class="col-4">تعداد کل محصول : {{ $product->quantity }}</div>
            <div class="col-4">تعداد سایز بندی شده : {{ $productSizeQuantity }}</div>
            <div class="col-4">تعداد فری سایز : {{$product->quantity - $productSizeQuantity }}</div>
        </div>
        <div class="card-body table-responsive">
            {{-- جدول سایزهای اضافه‌شده --}}
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>سایز</th>
                        <th>تعداد</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody id="size-collapse-group">
                    @foreach ($product->sizes as $size)
                        <tr>
                            <td class="col-md-3">
                                <input type="text" disabled class="form-control " value="{{ $size->size }}">
                            </td>
                            <td class="col-md-3">
                                <input type="number" disabled class="form-control dir-rtl"
                                    value="{{ $size->pivot->quantity }}">

                                    
                            </td>

                            <td>
                                <div class="d-flex gap-2 mt-1">
                                    <button class="btn btn-sm btn-outline-info" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#edit-size-{{ $size->id }}" aria-expanded="false"
                                        aria-controls="edit-size-{{ $size->id }}">
                                        ویرایش
                                    </button>
                                    <form
                                        action="{{ route('products.sizes.destroy', ['product' => $product->id, 'size' => $size->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('آیا از حذف این سایز مطمئن هستید؟')">
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Collapse فرم ویرایش --}}
                        <tr class="collapse" id="edit-size-{{ $size->id }}">
                            <td colspan="3">
                                <div class="card-body">
                                    <form
                                        action="{{ route('products.sizes.update', ['product' => $product->id, 'size' => $size->id]) }}"
                                        method="POST" class="row g-3 align-items-center">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-auto">
                                            <label class="form-label mb-0">ویرایش تعداد {{ $size->size }}</label>
                                        </div>

                                        <div class="col-md-3">
                                            <input type="number" name="quantity" value="{{ $size->pivot->quantity }}"
                                                class="form-control dir-rtl">
                                                <div class="text-danger">@error('quantity'){{ $message }}@enderror</div>
                                        </div>

                                        <div class="col-md-3 d-flex align-items-end">
                                            <button type="submit" class="btn btn-sm btn-outline-dark">ویرایش</button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="card-footer">
            @if ($sizes->diff($product->sizes)->isEmpty())
                <div class="alert alert-warning" role="alert">
                    سایزی برای ایجاد وجود ندارد! <a href="{{ route('sizes.index') }}" class="alert-link">ایجاد سایز</a>
                </div>
            @else
                {{-- فرم اضافه‌کردن سایز جدید --}}
                <form action="{{ route('products.sizes.store', $product->id) }}" method="POST" class="row g-3 mb-4">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label">انتخاب سایز</label>
                        <select name="size_id" class="form-select">
                            @foreach ($sizes as $size)
                                @if (!$product->sizes->contains($size->id))
                                    <option value="{{ $size->id }}">{{ $size->size }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">تعداد</label>
                        <input type="number" name="quantity" class="form-control dir-rtl" placeholder="مثلاً 5">
                        <div class="text-danger">@error('quantity'){{ $message }}@enderror</div>

                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-dark">افزودن سایز</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

@endsection

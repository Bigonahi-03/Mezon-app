@extends('layouts.master')
@section('title', 'Category Edit')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ویرایش دسته بندی</h4>
    </div>

    <form class="row gy-4" action="{{ route('category.update', ['category' => $category->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="col-md-4">
            <label class="form-label">نام</label>
            <input name="name" type="text" value="{{ $category->name }}" class="form-control dir-rtl" />
            <div class="text-danger">@error('name'){{ $message }}@enderror</div>
        </div>

        <div class="col-md-4">
            <label class="form-label">وضعیت</label>
            <select name="status" class="form-select">
                <option {{ $category->status === '1' ? 'selected' : '' }} value="1">فعال</option>
                <option {{ $category->status === '1' ? 'selected' : '' }} value="0">غیر فعال</option>
            </select>
            <div class="text-danger">@error('status'){{ $message }}@enderror</div>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش دسته بندی
            </button>
        </div>
    </form>
@endsection

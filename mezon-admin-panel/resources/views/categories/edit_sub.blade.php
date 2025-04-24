@extends('layouts.master')

@section('title', 'Edit Subcategory')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ویرایش زیرمجموعه</h4>
    </div>

    <form action="{{ route('category.update', $category->id) }}" method="POST" class="row gy-4">
        @csrf
        @method('PUT')

        <div class="col-md-6">
            <label class="form-label">نام دسته‌بندی اصلی</label>
            <input type="text" value="{{ $parentCategory->name }}" class="form-control" disabled />
            <input name="parent_id" type="hidden" value="{{ $parentCategory->id }}" />
        </div>

        <div class="col-md-6">
            <label class="form-label">نام زیرمجموعه</label>
            <input name="name" type="text" value="{{ old('name', $category->name) }}" class="form-control" />
            <div class="text-danger">@error('name'){{ $message }}@enderror</div>
        </div>

        <div class="col-md-6">
            <label class="form-label">وضعیت</label>
            <select name="status" class="form-select">
                <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : '' }}>فعال</option>
                <option value="0" {{ old('status', $category->status) == 0 ? 'selected' : '' }}>غیرفعال</option>
            </select>
            <div class="text-danger">@error('status'){{ $message }}@enderror</div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-outline-dark">ذخیره تغییرات</button>
        </div>
    </form>
@endsection

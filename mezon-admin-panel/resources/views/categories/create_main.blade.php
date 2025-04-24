@extends('layouts.master')

@section('title', 'Create Category')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ایجاد دسته‌بندی اصلی</h4>
    </div>

    <form action="{{ route('category.store') }}" method="POST" class="row gy-4">
        @csrf
        <div class="col-md-6">
            <label class="form-label">نام دسته‌بندی</label>
            <input name="name" type="text" value="{{ old('name') }}" class="form-control" />
            <div class="text-danger">@error('name'){{ $message }}@enderror</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">وضعیت</label>
            <select name="status" class="form-select">
                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>فعال</option>
                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>غیرفعال</option>
            </select>
            <div class="text-danger">@error('status'){{ $message }}@enderror</div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-outline-dark">ذخیره</button>
        </div>
    </form>
@endsection

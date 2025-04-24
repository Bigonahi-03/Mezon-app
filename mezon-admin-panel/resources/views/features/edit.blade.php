@extends('layouts.master')
@section('title', 'Feature Edit')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ویرایش ویژگی</h4>
    </div>

    <form class="row gy-4" action="{{ route('features.update', ['feature' => $feature->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="col-md-4">
            <label class="form-label">عنوان</label>
            <input name="title" type="text" value="{{ $feature->title }}" class="form-control dir-rtl" />
            <div class="text-danger">@error('title'){{ $message }}@enderror
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">ایکون</label>
            {{-- ورودی اسم ایکون همراه با آموزش وارد کرد و سایت مربوطه --}}
            <input name="icon" type="text" value="{{ $feature->icon }}" class="form-control"
                placeholder="نام کلاس آیکون را وارد کنید..." id="icon-input" data-bs-toggle="popover"
                data-bs-trigger="focus" data-bs-placement="top" data-bs-html="true"
                data-bs-content='لطفاً فقط نام کلاس آیکون را از سایت <a href="https://icons.getbootstrap.com/" target="_blank" class="text-primary w-50">Bootstrap Icons</a> وارد کنید (مثال: bi-heart).' />
            <div class="text-danger">
                @error('icon')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="col-md-12">
            <label class="form-label">متن</label>
            <textarea name="body" class="form-control" rows="3"> {{ $feature->body }}</textarea>
            <div class="text-danger">
                @error('body')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش ویژگی
            </button>
        </div>
    </form>
@endsection

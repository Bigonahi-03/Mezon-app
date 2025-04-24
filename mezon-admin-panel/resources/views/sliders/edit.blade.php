@extends('layouts.master')
@section('title', 'Slider Edit')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ویرایش اسلایدر</h4>
    </div>

    <form class="row gy-4" action="{{ route('sliders.update', ['slider' =>$slider->id ]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label class="form-label">عنوان</label>
            <input name="title" type="text" value="{{ $slider->title }}" class="form-control" />
            <div class="text-danger">@error('title'){{ $message }}@enderror</div>
        </div>

        <div class="col-md-3">
            <label class="form-label">عنوان لینک</label>
            <input name="link_title" type="text" value="{{ $slider->link_title }}" class="form-control" />
            <div class="text-danger">@error('link_title'){{ $message }}@enderror</div>
        </div>
        
        <div class="col-md-3">
            <label class="form-label">آدرس لینک</label>
            <input name="link_address" type="text" value="{{ $slider->link_address }}" class="form-control dir-ltr" />
            <div class="text-danger">@error('link_address'){{ $message }}@enderror</div>
        </div>

        <div class="col-md-12">
            <label class="form-label">متن</label>
            <textarea name="body" class="form-control" rows="3"> {{ $slider->body }}</textarea>
            <div class="text-danger">@error('body'){{ $message }}@enderror</div>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش اسلایدر
            </button>
        </div>
    </form>
@endsection

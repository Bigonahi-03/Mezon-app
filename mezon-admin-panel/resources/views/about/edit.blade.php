@extends('layouts.master')
@section('title', 'About Us Edit')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ویرایش درباره ما</h4>
    </div>

    <form class="row gy-4" action="{{ route('about-us.update', $aboutUs->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label class="form-label">عنوان</label>
            <input name="title" type="text" value="{{ $aboutUs->title }}" class="form-control" />
            <div class="text-danger">@error('title'){{ $message }}@enderror</div>
        </div>

        <div class="col-md-12">
            <label class="form-label">متن</label>
            <textarea name="body" class="form-control" rows="6"> {{ $aboutUs->body }}</textarea>
            <div class="text-danger">@error('body'){{ $message }}@enderror</div>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش درباره ما
            </button>
        </div>
    </form>
@endsection

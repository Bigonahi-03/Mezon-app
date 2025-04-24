@extends('layouts.master')
@section('title', 'Show Message')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold "> مشاهده پیام</h4>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">نام:</label>
                    <input type="text" value="{{ $contactUs->name }}" class="form-control" readonly />
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">ایمیل:</label>
                    <input type="email" value="{{ $contactUs->email }}" class="form-control text-start" readonly />
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">موضوع:</label>
                <input type="text" value="{{ $contactUs->subject }}" class="form-control" readonly />
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">متن پیام:</label>
                <textarea class="form-control" rows="5" readonly>{{ $contactUs->body }}</textarea>
            </div>

            <div class="d-flex mt-4">
                <a href="{{ route('contact-us.index') }}" class="btn btn-secondary ">بازگشت به صفحه قبل</a>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.master')

@section('title', 'Sliders')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">اسلایدرها</h4>
        <a href="{{ route('sliders.create') }}" class="btn btn-sm btn-outline-primary">ایجاد اسلایدر</a>
    </div>

    <div class="table-responsive">

        {{-- اگر هیچ اسلایدری وجود نداشت،
            پیام هشدار نمایش داده می‌شود به همراه لینک ساخت اسلایدر--}}
        @if ($sliders->isEmpty())
            <div class="alert alert-warning" role="alert">
                اسلایدری برای نمایش وجود ندارد! <a href="{{ route('sliders.create') }}" class="alert-link">ایجاد اسلایدر</a>
            </div>
        @else
            <table class="table align-middle  table-hover">
                <thead>
                    <tr>
                        <th>عنوان</th>
                        <th>متن</th>
                        <th>عنوان لینک</th>
                        <th>آدرس لینک</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($sliders as $slider)
                        <tr>
                            <td>{{ $slider->title }}</td>
                            <td>{{ $slider->body }}</td>
                            <td>{{ $slider->link_title }}</td>
                            <td class="dir-ltr">{{ e($slider->link_address) }}</td>
                            <td>
                                <div class="d-flex">

                                    <a href="{{ route('sliders.edit', ['slider' => $slider->id]) }}"
                                        class="btn btn-sm btn-outline-info me-2">ویرایش</a>

                                    {{-- فرم حذف اسلایدر با تأیید جاوااسکریپت --}}
                                    <form id="delete-form-slider-{{ $slider->id }}"
                                        action="{{ route('sliders.destroy', ['slider' => $slider->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmDelete('delete-form-slider-{{ $slider->id }}')">حذف</button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection

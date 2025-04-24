@extends('layouts.master')

@section('title', 'Features')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ویژگی ها</h4>
        <a href="{{ route('features.create') }}" class="btn btn-sm btn-outline-primary">ایجاد ویژگی</a>
    </div>


    {{-- اگر هیچ ویژگی وجود نداشت،
    پیام هشدار نمایش داده می‌شود به همراه لینک ساخت ویژگی --}}
    @if ($features->isEmpty())
        <div class="alert alert-warning" role="alert">
            ویژگی برای نمایش وجود ندارد! <a href="{{ route('features.crate') }}" class="alert-link">ایجاد ویژگی</a></div>
        </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle  table-hover">
                <thead>
                    <tr>
                        <th>عنوان</th>
                        <th>توضیحات</th>
                        <th>ایکون</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($features as $feature)
                        <tr>
                            <td>{{ $feature->title }}</td>
                            <td>{{ $feature->body }}</td>
                            <td><i class="bi {{ $feature->icon }} fs-3"></i></td>

                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('features.edit', ['feature' => $feature->id]) }}"
                                        class="btn btn-sm btn-outline-info me-2">ویرایش</a>

                                    {{-- فرم حذف ویژگی با تأیید جاوااسکریپت --}}
                                    <form id="delete-form-feature-{{ $feature->id }}"
                                        action="{{ route('features.destroy', ['feature' => $feature->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmDelete('delete-form-feature-{{ $feature->id }}')">حذف</button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    @endif

@endsection

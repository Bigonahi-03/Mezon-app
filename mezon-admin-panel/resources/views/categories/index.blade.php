@extends('layouts.master')

@section('title', 'Categories')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">دسته‌بندی‌ها</h4>
        <a href="{{ route('category.create') }}" class="btn btn-sm btn-outline-primary">ایجاد دسته‌بندی اصلی</a>
    </div>

    {{-- اگر هیچ اسلایدری وجود نداشت،
            پیام هشدار نمایش داده می‌شود به همراه لینک ساخت اسلایدر--}}
    @if ($categories->isEmpty())
        <div class="alert alert-warning" role="alert">
            هیچ دسته‌بندی‌ای برای نمایش وجود ندارد!
            <a href="{{ route('category.create') }}" class="alert-link">ایجاد دسته‌بندی</a>
        </div>
    @else
        <div class="row">
            @foreach ($categories as $category)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title fw-bold">{{ $category->name }}</h5>
                            <p class="card-text mb-0">{{ $category->status == 1 ? 'فعال' : 'غیرفعال' }}</p>
                            <div class="d-flex justify-content-end ">
                                <a href="{{ route('category.edit', $category->id) }}"
                                    class="btn btn-sm btn-outline-info me-2">ویرایش</a>
                                <form id="delete-form-categories-{{ $category->id }}" action="{{ route('category.destroy', $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('delete-form-categories-{{ $category->id }}')">حذف</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($category->children->count() > 0)
                                <h6 class="fw-bold mt-3">زیرمجموعه‌ها:</h6>
                                <ul class="list-group">
                                    @foreach ($category->children as $child)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div class="">{{ $child->name }}</div>
                                            <div>{{ $child->status ? 'فعال' : 'غیر غعال' }}</div>
                                            <div>
                                                <a href="{{ route('category.edit', $child->id) }}"
                                                    class="btn btn-sm btn-outline-info">ویرایش</a>
                                                <form id="delete-form-categories-{{ $child->id }}" action="{{ route('category.destroy', $child->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('delete-form-categories-{{ $child->id }}')">حذف</button>
                                                </form>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('category.create.sub', $category->id) }}" class="btn btn-sm btn-outline-primary mt-2">ایجاد زیرمجموعه </a>

                            @else
                                <div class="alert alert-warning mt-3" role="alert">
                                    زیرمجموعه‌ای برای این دسته‌بندی وجود ندارد!
                                    <a href="{{ route('category.create.sub', $category->id) }}" class="alert-link">افزودن
                                        زیرمجموعه</a>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection

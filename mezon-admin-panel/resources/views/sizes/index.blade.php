@extends('layouts.master')

@section('title', 'Size')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">سایز ها</h4>
    </div>
    
    <div >
        <form class="row align-items-center mb-4" action="{{ route('sizes.store') }}" method="POST">
            @csrf
            <div class="col-auto">
                <label class="form-label fw-bold">ایجاد سایز جدید</label>
            </div>
            <div class="col-auto">
                <input type="text" name="size" class="form-control mb-1" value="{{ old('size') }}">
                @error('size')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-dark mb-1">ایجاد سایز</button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>سایز</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sizes as $size)
                    <tr>
                        <td>{{ $size->size }}</td>
                        <td>
                            <div class="d-flex">

                                {{-- Button edit size --}}
                                <button class="btn btn-sm btn-outline-info me-2" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#edit-size-{{ $size->id }}" aria-expanded="false"
                                    aria-controls="edit-size-{{ $size->id }}">
                                    ویرایش
                                </button>

                                {{-- Form delete size --}}
                                <form id="delete-form-size-{{ $size->id }}"
                                    action="{{ route('sizes.destroy', ['size' => $size->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="confirmDelete('delete-form-size-{{ $size->id }}')">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Form edit size --}}
                    <tr class="collapse" id="edit-size-{{ $size->id }}">
                        <td colspan="2">
                            <div class="card card-body">
                                <form class="row align-items-center" action="{{ route('sizes.update', ['size' => $size->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-auto">
                                        <label class="form-label fw-bold">ویرایش سایز</label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="text" name="size" class="form-control mb-1"
                                            value="{{ $size->size }}">
                                        @error('size')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-outline-dark mb-1">ویرایش سایز</button>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

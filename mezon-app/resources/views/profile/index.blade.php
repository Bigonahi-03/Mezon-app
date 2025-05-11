@extends('profile.layouts.master')

@section('main')
        <div class="col-md-8 mt-5 mt-md-0">
            <form action="{{ route('profile.update') }}" method="POST" class="vh-70">
                @csrf
                @method('PUT')
                <div class="row g-4 ">
                    <div class="col-lg-6 col-sm-12 ">
                        <label class="form-label">نام و نام خانوادگی</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" />
                        <div class="text-danger">@error('name'){{ $message }}@enderror</div>
                    </div>
                    <div class=" col-lg-6 col-sm-12">
                        <label class="form-label">ایمیل</label>
                        <input type="text" name="email" class="form-control" value="{{ $user->email }}" />
                        <div class="text-danger">@error('email'){{ $message }}@enderror</div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <label class="form-label">شماره تلفن</label>
                        <input type="text" name="celphone" disabled class="form-control" value="{{ $user->cellphone }}" />
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">ذخیره ویرایش</button>
            </form>
        </div>

@endsection

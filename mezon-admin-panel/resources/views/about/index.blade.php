@extends('layouts.master')

@section('title', 'About-us')

@section('content')
<div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
    <h4 class="fw-bold ">درباره ما</h4>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="card-title ">{{ $aboutUs->title }}</h5>
        <p class="card-text ">{{ $aboutUs->body }}</p>
        <hr>
        <div class="d-flex justify-content-start">
            <a href="{{ route('about-us.edit', $aboutUs->id) }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-pencil-square"></i> ویرایش
            </a>
            
            
            
        </div>
    </div>
</div>

@endsection

@php
    $aboutUs = App\Models\AboutUs::first();
@endphp
@extends('layouts.master')

@section('title', 'About Us')

@section('content')

<section class="about_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6 ">
                <div class="">
                    <img src="images/about-img.jpg" width="400" alt="Image About Us" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="">
                    <div class="heading_container mb-4">
                        <h2>
                            {{ $aboutUs->title }}
                        </h2>
                    </div>
                    <p>
                        {{ $aboutUs->body }}
                    </p>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
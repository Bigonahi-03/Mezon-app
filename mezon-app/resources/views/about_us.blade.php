@php
    $aboutUs = App\Models\AboutUs::first();
@endphp
@extends('layouts.master')

@section('title', 'Contact Us')

@section('content')

<section class="about_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6 ">
                <div class="img-box">
                    <img src="images/about-img.jpg" alt="" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-box">
                    <div class="heading_container">
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
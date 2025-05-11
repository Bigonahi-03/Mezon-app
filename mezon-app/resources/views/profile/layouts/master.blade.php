@extends('layouts.master')
@section('title', 'Profile')

@section('content')
    <section class="profile_section layout_padding">
        <div class="container">
            <div class="row">

                @include('Profile.layouts.sidebar')

                @yield('main')

            </div>
        </div>
    </section>
@endsection

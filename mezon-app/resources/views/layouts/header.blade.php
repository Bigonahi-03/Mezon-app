<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mezon || @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('images/logo/trans_bg.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-+qdLaIRZfNu4cVPK/PxJJEy0B0f3Ugv8i482AKY7gwXwhaCroABd086ybrVKTa0q" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="./css/style.css">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @yield('link')

</head>

<body>
    <div class = "{{ request()->is('/') ? '' : 'sub_page' }}">
        <div class="hero_area ">
            <div class="bg-box">
                <img src="./images/hero-bg.jpg" alt="">
            </div>
            <!-- header section strats -->
            <header class="header_section">
                <div class="container">
                    <nav class="navbar navbar-expand-lg custom_nav-container">
                        <a class="navbar-brand" href="index.html">
                            <span>
                                Mezon
                            </span>
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mx-auto">
                                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('home') }}">صفحه اصلی</a>
                                </li>
                                <li class="nav-item {{ request()->is('menu') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('products.menu') }}">محصولات</a>
                                </li>
                                <li class="nav-item {{ request()->is('about_us') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('about_us') }}">درباره ما</a>
                                </li>
                                <li class="nav-item {{ request()->is('contact_us') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('contact_us') }}">تماس باما</a>
                                </li>
                            </ul>
                            <div class="user_option">
                                <a class="cart_link position-relative" href="cart.html">
                                    <i class="bi bi-cart-fill text-white fs-5"></i>
                                    <span class="position-absolute top-0 translate-middle badge rounded-pill">
                                        3
                                    </span>
                                </a>

                                @auth
                                    <button class="btn-auth">
                                        پروفایل
                                    </button>
                                @endauth

                                @guest
                                    <button id="loginBtn" class="btn-auth">
                                        ورود
                                    </button>
                                @endguest
                            </div>
                        </div>
                    </nav>
                </div>
            </header>
            <!-- end header section -->

            @include('components.login-modal')

            @if (request()->is('/'))
                @include('home.slider')
            @endif
        </div>
    </div>
</body>

</html>

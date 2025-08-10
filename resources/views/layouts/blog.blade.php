<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Blog</title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="surfside media" />
    
    <!-- Blog specific meta tags -->
    <link rel="apple-touch-icon" href="{{ asset('assets_v2/images/favicon.ico') }}">
    <link rel="icon" href="{{ asset('assets_v2/images/favicon.ico') }}" type="image/x-icon">
    <meta name="theme-color" content="#e87316">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Blog">
    <meta name="msapplication-TileImage" content="{{ asset('assets_v2/images/favicon.ico') }}">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Blog">
    <meta name="keywords" content="Blog">
    <meta name="author" content="Blog">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Nunito+Sans:wght@300;400;500;600;700&family=Be+Vietnam+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Blog CSS only from assets_v2 -->
    <link id="rtl-link" rel="stylesheet" type="text/css" href="{{ asset('assets_v2/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_v2/css/vendors/ion.rangeSlider.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_v2/css/vendors/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_v2/css/vendors/feather-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_v2/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_v2/css/vendors/slick/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_v2/css/vendors/slick/slick-theme.css') }}">
    <link id="color-link" rel="stylesheet" type="text/css" href="{{ asset('assets_v2/css/demo4.css') }}">

    <!-- Font phù hợp với tiếng Việt cho blog -->
    <style>
        body, html {
            font-family: 'Be Vietnam Pro', 'Inter', 'Nunito Sans', 'Jost', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        }

        /* Khắc phục chữ xanh có gạch chân */
        a {
            color: inherit !important;
            text-decoration: none !important;
        }

        a:hover {
            color: #222222 !important;
            text-decoration: none !important;
        }

        /* Đảm bảo hình ảnh blog không bị mờ */
        .blog-categority img {
            filter: none !important;
            opacity: 1 !important;
        }

        /* Remove any overlay effects */
        .blog-categority .overlay,
        .blog-categority::before,
        .blog-categority::after {
            display: none !important;
        }
    </style>

    @stack("styles")
</head>

<body>
    <!-- Simple header for blog -->
    <header class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-3">
                <div class="logo">
                    <a href="{{route('home.index')}}">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="max-height: 50px;" />
                    </a>
                </div>
                <nav>
                    <ul class="d-flex list-unstyled mb-0 gap-4">
                        <li><a href="{{route('home.index')}}" class="text-decoration-none">Home</a></li>
                        <li><a href="{{route('shop.index')}}" class="text-decoration-none">Shop</a></li>
                        <li><a href="{{route('blog.index')}}" class="text-decoration-none">Blog</a></li>
                        <li><a href="{{route('about.index')}}" class="text-decoration-none">About</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    @yield("content")

    <!-- Simple footer for blog -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </footer>

    <!-- Blog JS from assets_v2 -->
    <script src="{{ asset('assets_v2/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets_v2/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets_v2/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets_v2/js/lazysizes.min.js') }}"></script>
    <script src="{{ asset('assets_v2/js/slick.js') }}"></script>
    <script src="{{ asset('assets_v2/js/custom-slick.js') }}"></script>
    <script src="{{ asset('assets_v2/js/script.js') }}"></script>

    @stack("scripts")
</body>
</html>

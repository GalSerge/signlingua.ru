<!DOCTYPE html>
<html>

<head>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />

    <meta name="description" content="" />

    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    <meta property="og:image" content="" />
    <meta name="format-detection" content="telephone=no">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.svg') }}" />

    <title>{{ $title ?? '' }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/themify-icons.css') }}">

    <script src="https://cdn.tiny.cloud/1/{{ config('services.tiny_mce') }}/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>

    @if(isset($js))
    @foreach($js as $file)
    <script src="{{ $file }}"></script>
    @endforeach
    @endif
</head>

<body>

    <div class="page-wraper">

        <header class="header rs-nav">
            @include('admin.components.header')
        </header>

        <div class="page-content bg-white grid-admin-menu">
            <div class="p-4 admin-menu">
                @include('admin.components.menu')
            </div>
            <div class="mt-4">
                @yield('content')
            </div>
        </div>

    </div>

    <footer>
        @include('admin.components.footer')
    </footer>

    <button class="back-to-top fa fa-chevron-up"></button>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    {{--
    <script src="{{ asset('js/popper.min.js') }}"></script>--}}
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    {{--
    <script src="{{ asset('js/owl.carousel.js') }}"></script>--}}
    {{--
    <script src="{{ asset('js/functions.js') }}"></script>--}}

</body>

</html>
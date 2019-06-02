<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Styles -->
    <link href="{{ asset('plugins/animation/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css')  }}" rel="stylesheet">
    <style>
        .union-login-bg {
            background-image: url("{{ asset('images/resource/user-login-bg.jpg') }}") ;
            -webkit-background-size:cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
</head>

<body>

<div class="auth-wrapper union-login-bg">
    @yield('content')
</div>


<!-- Required Js -->
<script src="{{ asset('js/vendor-all.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/pcoded.min.js') }}"></script>

<!-- Tooltip Js -->
@yield('script')

</body>

</html>

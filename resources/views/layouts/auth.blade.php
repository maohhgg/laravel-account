<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title></title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Styles -->
    <link href="{{ asset('plugins/animation/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css')  }}" rel="stylesheet">
    <style>
        .union-login-bg {
            background: url("{{ asset('images/resource/user-login-bg-1.jpg') }}") center center no-repeat;
            -webkit-background-size:cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        .union-login-bg .card{
            background:rgba(255,255,255,0.7);
        }
        .union-login-bg .card .form-group{
            corlor:#333;
        }
        @media \0screen\,screen\9 {/* 只支持IE6、7、8 */
            .union-login-bg .card{
                background-color:#ffffff;
                filter:Alpha(opacity=50);
                position:static;
                *zoom:1;
            }
            .union-login-bg .card .card-block{
                position:relative;
            }
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

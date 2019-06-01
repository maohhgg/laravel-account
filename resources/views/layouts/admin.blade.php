<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!--[if lt IE 10]>
    <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Styles -->
    @yield('styles')
    @yield('component-styles')
    <link href="{{ asset('plugins/animation/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css')  }}" rel="stylesheet">
</head>

<body>

<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->

<!-- [ navigation menu ] start -->
@component('component.navigation')
@endcomponent
<!-- [ navigation menu ] end -->


<!-- [ Header ] start -->
@component('admin.component.header')
@endcomponent
<!-- [ Header ] end -->

<!-- [ Content ] start -->
@component('component.breadcrumb')
    @yield('content')
@endcomponent
<!-- [ Content ] end -->

<!-- Required Js -->
<script src="{{ asset('js/vendor-all.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/pcoded.min.js') }}"></script>



@yield('script')
@yield('component-script')
</body>

</html>

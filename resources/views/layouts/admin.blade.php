<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!--[if lt IE 10]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.3/html5shiv-printshiv.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Styles -->
    @yield('styles')
    @yield('component-styles')
    <link href="{{ asset('plugins/animation/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css')  }}" rel="stylesheet">
</head>

<body>


<!-- [ notification ] start -->

<div style="position:absolute;top:50px;right: 40px;width: 350px;z-index: 100000">
    <div class="toast hide toast-right" role="alert" aria-live="assertive" data-delay="3000" aria-atomic="true">
        <div class="toast-header">
            <img src="{{ asset('favicon.ico') }}" alt="" class="img-fluid mr-2">
            <strong class="mr-auto">通知</strong>
            <small class="text-muted"></small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body" id="toast-message">
            @if (session('toast'))
                {{ session('toast') }}
            @endif
        </div>
    </div>
</div>

<!-- [ notification ] end -->

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
@if (session('toast'))
    <script>
        $(document).ready(function () {
            $('.toast').toast('show');
        });
    </script>
@endif

@yield('script')
@yield('component-script')
</body>

</html>

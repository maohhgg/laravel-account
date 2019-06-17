<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">

                                <div class="page-header-title">
                                    @if ($breadcrumbs)
                                        <h5 class="m-b-10"> {{ $breadcrumbs[count($breadcrumbs)-1]->name }}</h5>
                                    @endif
                                </div>

                                <ul class="breadcrumb">
                                    @if ($breadcrumbs)
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('admin.home') }}"><i class="feather icon-home"></i></a>
                                        </li>
                                        @foreach($breadcrumbs as $breadcrumb)
                                            @if ($loop->last)
                                                <li class="breadcrumb-item"><a href="#">{{ $breadcrumb->name }}</a></li>
                                            @else
                                                <li class="breadcrumb-item">
                                                    <a href="{{ route($breadcrumb->url) }}">{{ $breadcrumb->name }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                {{ $slot }}
            </div>
        </div>
    </div>
    @if ($icp)
        <div class="pcoded-footer text-center">
            <div class="text-center">{{ $icp }}</div>
        </div>
    @endif
</div>
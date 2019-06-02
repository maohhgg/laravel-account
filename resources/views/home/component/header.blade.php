<header class="navbar pcoded-header navbar-expand-lg navbar-light">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse1"href="#"><span></span></a>
        <a href="{{ route('home') }}" class="b-brand">
            <div class="b-bg">
                <img src="{{ asset('images/resource/logo.png') }}" alt="">
            </div>
            <span class="b-title">查看数据</span>
        </a>
    </div>
    <a class="mobile-menu" id="mobile-header" href="#">
        <i class="feather icon-more-horizontal"></i>
    </a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li>
                <div class="dropdown drp-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-notification">
                        <div class="pro-head">
{{--                            <img src="{{ asset('images/user/'.Auth::user()->icon)}}" class="img-radius" alt="User-Profile-Image">--}}
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                        <ul class="pro-body">
{{--                            <li><a href="#" class="dropdown-item"><i class="feather icon-settings"></i> 修改个人资料</a></li>--}}
                            <li><a href="{{ route('admin.logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                   class="dropdown-item">
                                    <i class="feather icon-log-out"></i>  退出</a>
                            </li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>
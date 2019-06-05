<header class="navbar pcoded-header navbar-expand-lg navbar-light">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse1"href="#"><span></span></a>
        <a href="{{ route('admin.home') }}" class="b-brand">
            <div class="b-bg">
                <img src="{{ asset('images/resource/logo.png') }}" alt="">
            </div>
            <span class="b-title">后台管理</span>
        </a>
    </div>
    <a class="mobile-menu" id="mobile-header" href="#">
        <i class="feather icon-more-horizontal"></i>
    </a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li><a href="#" class="full-screen" onclick="javascript:toggleFullScreen()"><i class="feather icon-maximize"></i></a></li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown">新建项目</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('admin.data.create') }}">
                            <span class="pcoded-micon"><i class="feather icon-file-plus"></i></span>
                            <span class="pcoded-mtext">数据</span>
                        </a>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('admin.collect.create') }}">
                            <span class="pcoded-micon"><i class="feather icon-file-plus"></i></span>
                            <span class="pcoded-mtext">汇总数据</span>
                        </a>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('admin.users.create') }}">
                            <span class="pcoded-micon"><i class="feather icon-user-plus"></i></span>
                            <span class="pcoded-mtext">会员</span>
                        </a>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('admin.admins.create') }}">
                            <span class="pcoded-micon"><i class="feather icon-plus"></i></span>
                            <span class="pcoded-mtext">管理员</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li></li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li>
                <div class="dropdown drp-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon feather icon-settings"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-notification">
                        <div class="pro-head">
{{--                            <img src="{{ asset('images/user/'.Auth::user()->icon)}}" class="img-radius" alt="User-Profile-Image">--}}
                            <span>{{ auth('admin')->user()->name }}</span>
                        </div>
                        <ul class="pro-body">
{{--                            <li><a href="{{ route('admin.settings') }}" class="dropdown-item"><i class="feather icon-settings"></i> 修改个人资料</a></li>--}}
                            <li><a href="{{ route('admin.password') }}" class="dropdown-item"><i class="feather icon-lock"></i> 修改密码</a></li>
                            <li><a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                   class="dropdown-item">
                                    <i class="feather icon-log-out"></i>  退出</a>
                            </li>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>
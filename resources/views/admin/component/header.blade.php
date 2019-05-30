<header class="navbar pcoded-header navbar-expand-lg navbar-light">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse1"href="{{ route('admin') }}"><span></span></a>
        <a href="{{ route('admin') }}" class="b-brand">
            <div class="b-bg">
                <i class="feather icon-trending-up"></i>
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
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon feather icon-bell"></i></a>
                    <div class="dropdown-menu dropdown-menu-right notification">
                        <div class="noti-head">
                            <h6 class="d-inline-block m-b-0">消息中心</h6>
                            <div class="float-right">
                                <a href="#" class="m-r-10">全部已读</a>
                                <a href="#">清除</a>
                            </div>
                        </div>
                        <ul class="noti-body">
                            <li class="notification">
                                <div class="media">
                                    <img class="img-radius" src="{{ asset('images/user/avatar-1.jpg')}}" alt="Generic placeholder image">
                                    <div class="media-body">
                                        <p><strong>John Doe</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>30 min</span></p>
                                        <p>新的注册会员</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="noti-footer">
                            <a href="#">查看全部</a>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="dropdown drp-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon feather icon-settings"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-notification">
                        <div class="pro-head">
                            <img src="{{ asset('images/user/avatar-1.jpg')}}" class="img-radius" alt="User-Profile-Image">
                            <span>John Doe</span>
                        </div>
                        <ul class="pro-body">
                            <li><a href="#" class="dropdown-item"><i class="feather icon-settings"></i> 修改个人资料</a></li>
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
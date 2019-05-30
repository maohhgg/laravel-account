<nav class="pcoded-navbar">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a href="{{ route('admin') }}" class="b-brand">
                <div class="b-bg">
                    <i class="feather icon-trending-up"></i>
                </div>
                <span class="b-title">后台管理</span>
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="#"><span></span></a>
        </div>

        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar">

                @foreach($menus as $menu)
                    @if(!$menu->children->isEmpty())
                        @component('admin.component.navigation.nav.item',['item' => $menu])
                        @endcomponent
                    @else
                        @component('admin.component.navigation.nav.link',['link' => $menu])
                        @endcomponent
                    @endif
                @endforeach

            </ul>
        </div>
    </div>
</nav>
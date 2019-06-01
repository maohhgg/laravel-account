<nav class="pcoded-navbar">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a href="#" class="b-brand">
                <div class="b-bg">
                    <i class="feather icon-trending-up"></i>
                </div>
                <span class="b-title"></span>
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="#"><span></span></a>
        </div>

        <div class="navbar-content scroll-div">

            <ul class="nav pcoded-inner-navbar">
                <li class="nav-item pcoded-menu-caption">
                    <label>导航</label>
                </li>
                @foreach($menus as $menu)
                    @if(!$menu->children->isEmpty())
                        @component('component.navigation.nav.item',['item' => $menu])
                        @endcomponent
                    @else
                        @component('component.navigation.nav.link',['link' => $menu])
                        @endcomponent
                    @endif
                @endforeach

            </ul>
        </div>
    </div>
</nav>
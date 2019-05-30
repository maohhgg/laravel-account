<li data-username="{{ $item->action }}"
    class="nav-item pcoded-hasmenu @if($item->children->reduce(function($c,$i){return $c == $i->action ? true : $c;},$active) === true) active pcoded-trigger @endif">


    <a href="#" class="nav-link">
        <span class="pcoded-micon"><i class="feather icon-{{ $item->icon }}"></i></span>
        <span class="pcoded-mtext">{{ $item->name }}</span>
    </a>

    <ul class="pcoded-submenu">

        @foreach($item->children as $sub)
            @component('admin.component.navigation.submenu',[ 'sub' => $sub])
            @endcomponent
        @endforeach

    </ul>

</li>
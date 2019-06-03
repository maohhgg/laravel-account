<li data-username="{{ $item->action.$active }}"
    class="nav-item pcoded-hasmenu @if(strpos($active, $item->action) === 0 ) active pcoded-trigger @endif">


    <a href="#" class="nav-link">
        <span class="pcoded-micon"><i class="feather icon-{{ $item->icon }}"></i></span>
        <span class="pcoded-mtext">
            {{ $item->name }}
        </span>
    </a>

    <ul class="pcoded-submenu">

        @foreach($item->children as $sub)
            @component('component.navigation.submenu',[ 'sub' => $sub])
            @endcomponent
        @endforeach

    </ul>

</li>
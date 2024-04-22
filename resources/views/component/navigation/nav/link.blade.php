<li data-username="{{ $link->action }}" class="nav-item @if( $link->action == $active) active @endif">
    <a href="{{ route($link->url) }}" class="nav-link">
        <span class="pcoded-micon"><i class="feather icon-{{ $link->icon }}"></i></span>
        <span class="pcoded-mtext">{{ $link->name }}</span>
    </a>
</li>

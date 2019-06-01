<li class="@if($sub->action  == $active) active @endif">
    <a href="{{ route($sub->url) }}" class="">
        <span class="pcoded-micon"><i class="feather icon-{{ $sub->icon }}"></i></span>
        <span class="pcoded-mtext">{{ $sub->name }}</span>
    </a>
</li>
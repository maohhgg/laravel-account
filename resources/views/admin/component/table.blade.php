<div class="card User-Activity">
    <div class="card-header">
        <h5>{{ $title }}</h5>
        <div class="card-header-right">
            <div class="btn-group card-option">
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    <i class="feather icon-more-horizontal"></i>
                </button>
                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                    <li class="dropdown-item full-card">
                        <a href="#">
                            <span><i class="feather icon-maximize"></i> 全屏</span>
                            <span style="display:none"><i class="feather icon-minimize"></i> 还原</span>
                        </a>
                    </li>
                    <li class="dropdown-item minimize-card">
                        <a href="#">
                            <span><i class="feather icon-minus"></i> 折叠</span>
                            <span style="display:none"><i class="feather icon-plus"></i> 展开</span>
                        </a>
                    </li>
                    <li class="dropdown-item reload-card">
                        <a href="#"><i class="feather icon-refresh-cw"></i> 刷新</a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
    <div class="card-block pb-0">
        <div class="table-responsive">
            <table class="table text-center">
                <thead>
                <tr>
                    @foreach($items as $item)
                        <td>{{$item}}</td>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                    {{ $slot }}
                </tbody>
            </table>

        </div>

    </div>
</div>
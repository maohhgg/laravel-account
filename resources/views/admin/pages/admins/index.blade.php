@extends('layouts.admin')
@section('content')

    <!-- [ Main Content ] start -->
    <div class="card User-Activity">
        <div class="card-header">
            <h5>数据列表</h5>
            <div class="card-header-right">
                <div class="btn-group card-option">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <th>#ID</th>
                        <th>名称</th>
                        <th>邮箱</th>
                        <th>创建时间</th>
                        <th>上次登录时间</th>
                        <th>状态</th>
                    </tr></thead>
                    <tbody>
                    <tr>

                    @foreach($admins as $admin)
                        <tr>
                            <td><h6 class="m-0">{{ $admin->id }}</h6></td>
                            <td><h6 class="m-0">{{ $admin->name }}</h6></td>
                            <td><h6 class="m-0">{{ $admin->email }}</h6></td>
                            <td><h6 class="m-0">{{ $admin->created_at->format('Y-m-d') }}</h6></td>
                            <td><h6 class="m-0">{{ $admin->updated_at->format('Y-m-d') }}</h6></td>
                            <td>
                                <div class="form-group">
                                    <div class="switch d-inline m-r-10">
                                        <input type="checkbox" id="switch-s-{{ $admin->id }}" @if($admin->id == 1) disabled  @endif checked>
                                        <label for="switch-s-{{ $admin->id }}" class="cr"></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" id="zero-configuration_info" role="status" aria-live="polite">Showing 1 to 10 of 17 entries</div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

        </div>
    </div>
    <!-- [ Main Content ] end -->


@endsection
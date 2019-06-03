@extends('layouts.admin')
@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>管理员基本信息</h5>
                    <span class="d-block m-t-5">编辑 <code>管理员</code> 信息</span>
                </div>
                <div class="card-block">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                        <form action="{{ route('admin.admins.add') }}" method="post">
                            @csrf
                            {{  Form::hidden('url',URL::previous())  }}

                            <div class="form-group mb-3">
                                <label class="form-label">网站名称</label>
                                <input name="servername" type="text"
                                       class="form-control @error('servername') border-danger @enderror"
                                       placeholder="用户名"
                                       @error('servername') data-toggle="tooltip" data-placement="top"
                                       title="{{ $message }}" @enderror
                                       value="{{ old('servername') ?? $results['server_name'] }}" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">充值二维码</label>

                                </div>
                                <div class="col-md-6">
                                    <form action="{{ route('admin.upload') }}" class="dropzone dz-clickable">
                                    <div class="dz-default dz-message"><span>拖动文件上传</span></div></form>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary">更新</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

@endsection
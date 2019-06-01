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
                        <form action="{{ route('admin.admins.create') }}" method="post">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label">用户名</label>
                                <input name="name" type="text"
                                       class="form-control @error('name') border-danger @enderror"
                                       placeholder="用户名"
                                       @error('name') data-toggle="tooltip" data-placement="top"
                                       title="{{ $message }}" @enderror
                                       value="{{ old('name') }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">密码</label>
                                <input name="password" type="text"
                                       class="form-control @error('password') border-danger @enderror"
                                       placeholder="密码"
                                       @error('password') data-toggle="tooltip" data-placement="top"
                                       title="{{ $message }}" @enderror
                                       value="{{ old('password') }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">创建</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

@endsection
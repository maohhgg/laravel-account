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
                        <form action="{{ route('admin.admins.save') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $admin->id }}">
                            <div class="form-group mb-3">
                                <label class="form-label">用户名</label>
                                <input name="name" type="text"
                                       class="form-control @error('name') border-danger @enderror"
                                       placeholder="用户名"
                                       @error('name') data-toggle="tooltip" data-placement="top"
                                       title="{{ $message }}" @enderror
                                       value="{{ old('name') ?? $admin->name }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">邮箱地址</label>
                                <input name="email" type="text"
                                       class="form-control @error('email') border-danger @enderror"
                                       placeholder="邮箱地址"
                                       @error('email') data-toggle="tooltip" data-placement="top"
                                       title="{{ $message }}" @enderror
                                       value="{{ old('email') ?? $admin->email }}" required>
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
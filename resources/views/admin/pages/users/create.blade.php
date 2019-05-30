@extends('layouts.admin')
@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>会员基本信息</h5>
                    <span class="d-block m-t-5">编辑 <code>会员</code> 信息</span>
                </div>
                <div class="card-block">
                    <form action="{{ route('admin.users.create') }}" method="post">
                        @csrf
                        <div class="row form-group">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                                <div class="form-group">
                                    <label class="form-label">名称</label>
                                    <input type="text" name="name" class="form-control" placeholder="example">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                                <div class="form-group">
                                    <label class="form-label">邮箱地址</label>
                                    <input type="email" class="form-control" name="email" placeholder="example@example.org">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                                <div class="form-group">
                                    <label class="form-label">密码</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                                <div class="form-group">
                                    <label class="form-label">确认密码</label>
                                    <input type="password" class="form-control" name="confirm-password" placeholder="Password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">是否启用</label>
                            <div class="custom-checkbox">
                                <div class="switch d-inline m-r-10">
                                    <input name="active" type="checkbox" class="switcher-input" name="validation-switcher" id="switch-admins-active" checked>
                                    <label for="switch-admins-active" class="cr"></label>
                                </div>
                                <label id="admins-active-status">激活</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">创建</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

@endsection
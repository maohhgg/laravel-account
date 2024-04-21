@extends('layouts.auth')
@section('content')
    <div class="auth-content subscribe">
        <form class="md-float-material form-material" action="{{ route('admin.password.request') }}" method="post">
            @csrf
            <div class="card">
                <div class="row no-gutters">
                    <div class="col-md-4 col-lg-6 d-none d-md-flex d-lg-flex theme-bg align-items-center justify-content-center">
                        <img src="{{ asset('images/user/lock.png') }}" alt="lock images" class="img-fluid">
                    </div>
                    <div class="col-md-8 col-lg-6">
                        <div class="card-body text-center">
                            <div class="row justify-content-center">
                                <div class="col-sm-10">
                                    <div class="mb-4">
                                        <i class="feather icon-mail auth-icon"></i>
                                    </div>
                                    <h3 class="mb-4">找回密码</h3>
                                    <div class="input-group mb-3">
                                        <input name="email" type="email"
                                               class="form-control @error('email') border-danger @enderror"
                                               placeholder="邮箱"
                                               @error('email') data-toggle="tooltip" data-placement="top"
                                               title="{{ $message }}"
                                               @enderror
                                               value="{{ old('email') }}" required>
                                    </div>
                                    <button class="btn btn-primary mb-4 shadow-2">发送邮件</button>
                                    <p class="mb-0 text-muted">记得密码? <a href="{{ route('admin.login') }}">登录</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

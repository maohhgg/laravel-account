@extends('layouts.auth')

@section('content')
    <div class="auth-content subscribe">
        <form method="POST" action="{{ route('admin.password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
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
                                        <i class="feather icon-lock auth-icon"></i>
                                    </div>
                                    <h3 class="mb-4">找回密码</h3>


                                    <div class="input-group mb-3">
                                        <input name="email" type="email" class="form-control" value="{{ $email }}"
                                               required>
                                    </div>

                                    <div class="input-group mb-3">
                                        <input name="password" type="password"
                                               class="form-control @error('password') border-danger @enderror"
                                               placeholder="密码"
                                               @error('password') data-toggle="tooltip" data-placement="top"
                                               title="{{ $message }}"
                                               @enderror
                                               value="{{ old('password') }}" required>
                                    </div>
                                    <div class="input-group mb-4">
                                        <input name="confirm-password" type="password"
                                               class="form-control @error('confirm-password') border-danger @enderror"
                                               placeholder="确认密码"
                                               @error('confirm-password') data-toggle="tooltip" data-placement="top"
                                               title="{{ $message }}"
                                               @enderror
                                               value="{{ old('confirm-password') }}" required>
                                    </div>

                                    <button class="btn btn-primary shadow-2 mb-4">生成密码</button>
                                    <p class="mb-0 text-muted">记起密码了? <a href="{{ route('login') }}">登录</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
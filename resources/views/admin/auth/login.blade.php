@extends('layouts.auth')

@section('content')

    <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                    <form class="md-float-material form-material" action="{{ route('admin.login') }}" method="post">
                        @csrf
                        <div class="text-center">
                            <img src="{{ asset('images/logo.png') }}" alt="logo.png">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center txt-primary">登录</h3>
                                    </div>
                                </div>
                                <p class="text-muted text-center p-b-5">Sign in with your regular account</p>
                                <div class="form-group form-primary @error('email') has-danger @enderror">
                                    <input type="text" name="email" class="form-control @error('email') fill @enderror" value="{{ old('email') }}" required />
                                    <span class="form-bar"></span>
                                    <label class="float-label">邮箱地址</label>
                                    @error('email')
                                    <span class="col-form-label" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" name="password" class="form-control" required />
                                    <span class="form-bar"></span>
                                    <label class="float-label">密码</label>
                                </div>
                                <div class="row m-t-25 text-left">
                                    <div class="col-12">
                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span class="text-inverse">记住我</span>
                                            </label>
                                        </div>
                                        <div class="forgot-phone text-right float-right">
                                            <a href="{{ route('admin.forgot') }}" class="text-right f-w-600"> 忘记密码?</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-25">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">登录</button>
                                    </div>
                                </div>
                                {{--  <p class="text-inverse text-left">还没有账户？<a href="{{ route('admin.register') }}"> <b>注册</b></a>或者联系管理员</p>--}}
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </section>

@endsection
@extends('layouts.auth')

@section('content')

    <div class="auth-content subscribe">
        <!-- Authentication card start -->
        <form class="md-float-material form-material" action="{{ route('admin.login') }}" method="post">
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
                                    <h3 class="mb-4">登录</h3>
                                    <div class="input-group mb-3">
                                        <input name="email" type="email"
                                               class="form-control @error('email') border-danger @enderror"
                                               placeholder="邮箱"
                                               @error('email') data-toggle="tooltip" data-placement="top"
                                               title="{{ $message }}" @enderror
                                               value="{{ old('email') }}" required>
                                    </div>
                                    <div class="input-group mb-4">
                                        <input name="password" type="password" class="form-control" placeholder="密码"
                                               required>
                                    </div>
                                    <div class="form-group text-left">
                                        <div class="checkbox checkbox-fill d-inline">
                                            <input name="remember" type="checkbox" name="checkbox-fill-1"
                                                   id="checkbox-fill-a1" {{ old('remember') ? 'checked' : '' }}>
                                            <label for="checkbox-fill-a1" class="cr">记住我</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary shadow-2 mb-4">登录</button>
{{--                                    <p class="mb-2 text-muted">忘记密码了？ <a href="{{ route('admin.password.request') }}">重置</a></p>--}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

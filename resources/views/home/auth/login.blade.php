@extends('layouts.auth')

@section('content')
    <div class="auth-content">
        <div class="auth-bg">
            <span class="r"></span>
            <span class="r s"></span>
            <span class="r s"></span>
            <span class="r"></span>
        </div>
        <div class="card">
            <!-- Authentication card start -->
            <form class="md-float-material form-material" action="{{ route('login') }}" method="post">
                @csrf
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="feather icon-unlock auth-icon"></i>
                    </div>
                    <h3 class="mb-4">登录</h3>

                    <div class="form-group mb-3">
                        <input name="email" type="email"
                               class="form-control @error('email') border-danger @enderror" placeholder="邮箱"
                               @error('email') data-toggle="tooltip" data-placement="top" title="{{ $message }}"
                               @enderror
                               value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group mb-4">
                        <input name="password" type="password" class="form-control" placeholder="密码" required>
                    </div>
                    <div class="form-group text-left">
                        <div class="checkbox checkbox-fill d-inline">
                            <input name="remember" type="checkbox" name="checkbox-fill-1"
                                   id="checkbox-fill-a1" {{ old('remember') ? 'checked' : '' }}>
                            <label for="checkbox-fill-a1" class="cr">记住我</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary shadow-2 mb-4">登录</button>
                    <p class="mb-2 text-muted">忘记密码了？<a href="{{ route('password.request') }}">重置</a></p>
                    <p class="mb-0 text-muted">还没有账户? <a href="{{ route('register') }}">注册</a></p>
                </div>
            </form>
        </div>
    </div>

@endsection

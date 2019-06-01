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
            <form class="md-float-material form-material" action="{{ route('register') }}" method="post">
                @csrf
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="feather icon-user-plus auth-icon"></i>
                    </div>
                    <h3 class="mb-4">注册</h3>
                    <div class="input-group mb-3">
                        <input name="name" type="text"
                               class="form-control @error('name') border-danger @enderror"
                               placeholder="用户名"
                               @error('name') data-toggle="tooltip" data-placement="top"
                               title="{{ $message }}" @enderror
                               value="{{ old('name') }}" required>
                    </div>
                    <div class="input-group mb-3">
                        <input name="email" type="email"
                               class="form-control @error('email') border-danger @enderror" placeholder="邮箱"
                               @error('email') data-toggle="tooltip" data-placement="top" title="{{ $message }}"
                               @enderror
                               value="{{ old('email') }}" required>
                    </div>
                    <div class="input-group mb-3">
                        <input name="phone" type="text"
                               class="form-control @error('phone') border-danger @enderror" placeholder="电话号码"
                               @error('phone') data-toggle="tooltip" data-placement="top" title="{{ $message }}"
                               @enderror
                               value="{{ old('phone') }}" required>
                    </div>
                    <div class="input-group mb-3">
                        <input name="password" type="password"
                               class="form-control @error('password') border-danger @enderror" placeholder="密码"
                               @error('password') data-toggle="tooltip" data-placement="top" title="{{ $message }}"
                               @enderror
                               value="{{ old('password') }}" required>
                    </div>
                    <div class="input-group mb-4">
                        <input name="password_confirmation" type="password"
                               class="form-control @error('password_confirmation') border-danger @enderror" placeholder="确认密码"
                               @error('password_confirmation') data-toggle="tooltip" data-placement="top" title="{{ $message }}"
                               @enderror
                               value="{{ old('confirm-password') }}" required>
                    </div>

                    <button class="btn btn-primary shadow-2 mb-4">注册</button>
                    <p class="mb-0 text-muted">已经有账户了? <a href="{{ route('login') }}"> 登录</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection

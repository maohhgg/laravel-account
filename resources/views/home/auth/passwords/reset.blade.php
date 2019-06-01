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
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="card-body text-center">
                    <h5 class="mb-4">找回密码</h5>

                    <div class="input-group mb-3">
                        <input name="email" type="email" class="form-control" value="{{ $email }}" required>
                    </div>

                    <div class="input-group mb-3">
                        <input name="password" type="password"
                               class="form-control @error('password') border-danger @enderror" placeholder="密码"
                               @error('password') data-toggle="tooltip" data-placement="top" title="{{ $message }}"
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
            </form>
        </div>
    </div>
@endsection
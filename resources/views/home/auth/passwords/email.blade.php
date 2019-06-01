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
            <form class="md-float-material form-material" action="{{ route('password.request') }}" method="post">
                @csrf
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="feather icon-mail auth-icon"></i>
                    </div>
                    <h3 class="mb-4">找回密码</h3>
                    <div class="input-group mb-3">
                        <input name="email" type="email"
                               class="form-control @error('email') border-danger @enderror" placeholder="邮箱"
                               @error('email') data-toggle="tooltip" data-placement="top" title="{{ $message }}"
                               @enderror
                               value="{{ old('email') }}" required>
                    </div>
                    <button class="btn btn-primary mb-4 shadow-2">发送邮件</button>
                    <p class="mb-0 text-muted">记得密码? <a href="{{ route('login') }}">登录</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.auth')

@section('content')
    <div class="auth-wrapper">
        <div class="auth-content">
            <div class="auth-bg">
                <span class="r"></span>
                <span class="r s"></span>
                <span class="r s"></span>
                <span class="r"></span>
            </div>
            <div class="card">
                <!-- Authentication card start -->
                <form class="md-float-material form-material" action="{{ route('admin.login') }}" method="post">
                    @csrf
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <i class="feather icon-unlock auth-icon"></i>
                        </div>
                        <h3 class="mb-4">Login</h3>
                        <div class="input-group mb-3">
                            <input name="email" type="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                        </div>
                        <div class="input-group mb-4">
                            <input name="password" type="password" class="form-control" placeholder="password" required>
                        </div>
                        <div class="form-group text-left">
                            <div class="checkbox checkbox-fill d-inline">
                                <input name="remember" type="checkbox" name="checkbox-fill-1" id="checkbox-fill-a1" {{ old('remember') ? 'checked' : '' }}>
                                <label for="checkbox-fill-a1" class="cr"> Save credentials</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary shadow-2 mb-4">Login</button>
                        <p class="mb-2 text-muted">Forgot password? <a href="{{ route('admin.forgot') }}">Reset</a></p>
    {{--                    <p class="mb-0 text-muted">Don’t have an account? <a href="auth-signup.html">Signup</a></p>--}}
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
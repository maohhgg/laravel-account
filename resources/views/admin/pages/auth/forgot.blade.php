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
                <form class="md-float-material form-material" action="{{ route('admin.forgot') }}" method="post">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <i class="feather icon-mail auth-icon"></i>
                        </div>
                        <h3 class="mb-4">Reset Password</h3>
                        <div class="input-group mb-3">
                            <input name="email" type="email" class="form-control" placeholder="Email">
                        </div>
                        <button class="btn btn-primary mb-4 shadow-2">Reset Password</button>
                        <p class="mb-0 text-muted">Don’t have an account? <a href="{{ route('admin.login') }}">Signup</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </section>
@endsection

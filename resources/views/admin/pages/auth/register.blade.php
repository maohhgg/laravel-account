@extends('layouts.auth')
@section('content')
    <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                    <form class="md-float-material form-material" action="{{ route('admin.register') }}" method="post">
                        @csrf
                        <div class="text-center">
                            <img src="{{ asset('images/logo.png') }}" alt="logo.png">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center txt-primary">Sign up</h3>
                                    </div>
                                </div>
                                <p class="text-muted text-center p-b-5">Sign up with your regular account</p>
                                <div class="form-group form-primary">
                                    <input type="text" name="name" class="form-control @error('name') fill @enderror" value="{{ old('name') }}" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Choose Username</label>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="tel" name="phone" class="form-control @error('phone') fill @enderror" required value="{{ old('phone') }}">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Your Phone Number</label>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="email" name="email" class="form-control @error('email') fill @enderror" required value="{{ old('email') }}" }}>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Your Email Address</label>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-primary">
                                            <input id="password" type="password" name="password" class="form-control" required>
                                            <span class="form-bar"></span>
                                            <label class="float-label">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-primary">
                                            <input id="confirm-password" type="password" name="confirm-password" class="form-control" required>
                                            <span class="form-bar"></span>
                                            <label class="float-label">Confirm Password</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Sign up now</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-10">
                                        <p class="text-inverse text-left m-b-0">Thank you.</p>
                                        <p class="text-inverse text-left"><a href="{{ route('admin.login') }}"><b>Back to website</b></a></p>
                                    </div>
                                    <div class="col-md-2">
                                        <img src="{{ asset('images/logo-small-bottom.png') }}" alt="small-logo.png">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

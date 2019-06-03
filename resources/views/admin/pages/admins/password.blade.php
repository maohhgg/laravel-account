@extends('layouts.admin')
@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>更新密码</h5>
                </div>
                <div class="card-block">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                        <form action="{{ route('admin.password.save') }}" method="post">
                            @csrf
                            {{  Form::hidden('url',URL::previous())  }}
                            <div class="form-group mb-3">
                                {{ Form::label('email', '当前密码', array('class' => 'form-label') ) }}
                                <input name="current_password" type="password"
                                       class="form-control @error('current_password') border-danger @enderror"
                                       placeholder="密码"
                                       @error('current_password') data-toggle="tooltip" data-placement="top"
                                       title="{{ $message }}" @enderror
                                       required>
                            </div>

                            <div class="form-group mb-3">
                                {{ Form::label('email', '新密码', array('class' => 'form-label') ) }}
                                <input name="password" type="password"
                                       class="form-control @error('password') border-danger @enderror"
                                       placeholder="密码"
                                       @error('password') data-toggle="tooltip" data-placement="top"
                                       title="{{ $message }}" @enderror required>
                            </div>

                            <div class="form-group mb-3">
                                {{ Form::label('email', '确认新密码', array('class' => 'form-label') ) }}
                                <input name="password_confirmation" type="password"
                                       class="form-control @error('password') border-danger @enderror"
                                       placeholder="密码"
                                       @error('password') data-toggle="tooltip" data-placement="top"
                                       title="{{ $message }}" @enderror required>
                            </div>


                            <button type="submit" class="btn btn-primary">更新</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

@endsection
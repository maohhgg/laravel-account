@extends('layouts.admin')
@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>会员基本信息</h5>
                    <span class="d-block m-t-5">编辑 <code>会员</code> 信息</span>
                </div>
                <div class="card-block">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                        <form action="{{ route('admin.users.save') }}" method="post">
                            @csrf
                            {{  Form::hidden('url',URL::previous())  }}
                            {{  Form::hidden('id', $user->id)  }}

                            <div class="form-group mb-3">

                                <label class="form-label">用户名</label>
                                @if ($errors->has('name'))
                                    {{ Form::text('name', old('name'), $user->validateError($errors->first('name'))) }}
                                @else
                                    {{ Form::text('name', $user->name, ['class' => 'form-control'])  }}
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">电话号码
                                    <small>输入<span class="text-c-purple">13800000000</span> 删除</small>
                                </label>
                                @if ($errors->has('phone'))
                                    {{ Form::text('phone', old('phone'), $user->validateError($errors->first('phone'))) }}
                                @else
                                    {{ Form::text('phone', $user->phoneDefault() ? null: $user->phone, ['class' => 'form-control' ,'placeholder'=> '电话号码'])  }}
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">邮箱地址
                                    <small>输入<span class="text-c-purple">default@example.org</span> 删除</small>
                                </label>
                                @if ($errors->has('email'))
                                    {{ Form::text('email', old('email'), $user->validateError($errors->first('email'))) }}
                                @else
                                    {{ Form::text('email', $user->emailDefault() ? null: $user->email, ['class' => 'form-control' ,'placeholder'=> '邮箱'])  }}
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">密码</label>
                                @if ($errors->has('password'))
                                    {{ Form::text('password', old('password'), $user->validateError($errors->first('password'))) }}
                                @else
                                    {{ Form::password('password', ['class' => 'form-control' ,'placeholder'=> '密码'])  }}
                                @endif
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
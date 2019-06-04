@extends('layouts.app')
@section('content')
    <div class="auth-wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="card-header">
                    <h5>确认充值</h5>
                </div>
                <div class="card-block">
                    <div class="mb-5">
                        <h2 class="mb-4 text-center f-w-500 text-c-red">{{ $params['trxamt'] }}<span
                                    class=" m-r-3 f-14 text-muted">元</span></h2>
                        <h5 class="text-muted">
                            <span class="f-14 mr-1">充值给：</span>
                            <span class="text-c-blue">{{ auth()->user()->name }}</span>
                        </h5>
                    </div>
                    <form action="{{ $url }}" method="post">
                        @foreach($params as $key =>  $param)
                            {{  Form::hidden($key,  $param)  }}
                        @endforeach
                        <button class="btn btn-primary shadow-2 text-uppercase btn-block"
                                style="max-width:150px;margin:0 auto;">前往充值页面
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection


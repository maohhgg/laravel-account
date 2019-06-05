@extends('layouts.app')
@section('content')
    <div class="auth-wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="card-header">
                    <h5>充值结果</h5>
                </div>
                <div class="card-block">
                    <div class="mb-5">
                        @if($results['code']  == 200)
                            <h2 class="mb-4 text-center text-c-green f-w-500">{{ $results['message'] }}</h2>
                        @elseif($results['code']  == 400)
                         <h2 class="mb-4 text-center text-c-red f-w-500">{{ $results['message'] }}</h2>
                        @else
                            <h2 class="mb-4 text-center text-c-yellow f-w-500">{{ $results['message'] }}</h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
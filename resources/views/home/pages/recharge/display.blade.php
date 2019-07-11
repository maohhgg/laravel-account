@extends('layouts.app')
@section('content')
    <!-- [ Main Content ] start -->
    @if(!$results->isEmpty())
        @component('component.table',['items' => $items,'results' => $results,'target' => 'order'])
            @slot('title')
                充值订单
            @endslot

            @foreach($results as $v)
                <tr>
                    <td><h6 class="m-0 text-c-blue">{{ $v->order }}</h6></td>
                    <td><h6 class="m-0 text-c-blue">{{ $v->pay_number }}</h6></td>
                    <td>
                        @if($v->order_status_id == \App\Library\Recharge::SUCCESS)
                            <h6 class="m-0 text-c-green">{{ $v->orderStatus->label }}</h6>
                        @elseif($v->order_status_id == \App\Library\Recharge::PROCESS)
                            <h6 class="m-0 text-c-purple">{{ $v->orderStatus->label}}</h6>
                        @else
                            <h6 class="m-0 text-c-red">{{ $v->orderStatus->label }}</h6>
                        @endif
                    </td>
                    <td><h6 class="m-0">{{ $v->created_at }}</h6></td>

                    @if($v->order_status_id == \App\Library\Recharge::PROCESS)
                        <td><a class="text-c-green" href="{{ route('restartPay' ,[$v->order]) }}">前往支付</a></td>
                    @else
                        <td></td>
                    @endif
                </tr>
            @endforeach
        @endcomponent
    @else
        <div class="auth-wrapper offline">
            <div class="text-center">
                <h3 class="mb-4">还没有提交过订单</h3>
            </div>
        </div>
    @endif
@endsection
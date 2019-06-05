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
                    <td><h6 class="m-0"><a href="{{ route('restartPay' ,[$v->order]) }}">{{ $v->order }}</a></h6></td>
                    <td><h6 class="m-0 text-c-blue">{{ $v->pay_number }}</h6></td>

                    <td><h6 class="m-0">{{ date('Y-m-d',strtotime($v->created_at)) }}</h6></td>
                    <td>
                        @if($v->is_cancel == 0)
                            <h6 class="m-0 text-c-green">{{ $v->status }}</h6>
                        @elseif($v->is_cancel > 1)
                            <h6 class="m-0 text-c-yellow">{{ $v->status }}</h6>
                        @else
                            <h6 class="m-0 text-c-red">{{ $v->status }}</h6>
                        @endif
                    </td>
                    @if ($v->is_cancel == 4)
                        <td><a href="{{ route('restartPay' ,[$v->order]) }}">前往支付</a></td>
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
@extends('layouts.admin')
@section('content')
    <!-- [ Main Content ] start -->
    @if(!$results->isEmpty())
        @component('component.table',['items' => $items,'results' => $results,'target' => 'order'])
            @slot('title')
                充值订单
            @endslot

            @foreach($results as $v)
                <tr>
                    <td><h6 class="m-0">{{ $v->order }}</h6></td>
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
                </tr>
            @endforeach
        @endcomponent
    @else
        还没有数据
    @endif
@endsection
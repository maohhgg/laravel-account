@extends('layouts.admin')
@section('content')
    <!-- [ Main Content ] start -->
    @if(!$results->isEmpty())
        @component('component.table',['items' => $items,'results' => $results,'target' => 'order'])
            @slot('title')
                @if(!is_null($user))
                    用户 <span class="text-c-blue">{{ $user->name }}</span> 的
                @elseif(!is_null($order))
                    单号为 <span class="text-c-blue">{{ $order }}</span> 的
                @endif数据
            @endslot

            @foreach($results as $v)
                <tr>
                    <td><h6 class="m-0">{{ $loop->remaining+1 }}</h6></td>
                    <td><h6 class="m-0">{{ $v->order }}</h6></td>
                    <td>
                        @if($v->is_cancel == 0)
                            <h6 class="m-0">
                                <a href="{{ route('admin.data.order',[$v->turnover->order]) }}">{{ $v->turnover->order }}</a>
                            </h6>
                        @else
                            <h6 class="m-0">空</h6>
                        @endif
                    </td>
                    <td>
                        <h6 class="m-0">
                            <a href="{{ route('admin.order.user',[$v->user->id]) }}">{{ $v->user->name }}</a>
                        </h6>
                    </td>
                    <td><h6 class="m-0 text-c-blue">{{ $v->pay_number }}</h6></td>

                    <td><h6 class="m-0">{{ date('Y-m-d',strtotime($v->created_at)) }}</h6></td>
                    <td>
                        @if($v->is_cancel == 0)
                            <h6 class="m-0 text-c-green">{{ $v->status }}</h6>
                        @elseif($v->is_cancel > 1)
                            <h6 class="m-0 text-c-purple">{{ $v->status }}</h6>
                        @else
                            <h6 class="m-0 text-c-red">{{ $v->status }}</h6>
                        @endif
                    </td>

                    <td>
                        <a class="text-white label bg-c-blue f-16 toolbar" href="#"
                           data-content="{{ $v->id }}">
                            <i class="icon feather icon-settings"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        @endcomponent
        <div id="toolbar-options" class="hidden">
            <a data-content="delete"><i class="feather icon-trash-2"></i></a>
        </div>
    @elseif(!is_null($order))
        <h2>不存在单号为<span class="text-c-red">{{ $order }}</span>的数据</h2>
    @else
        还没有数据
    @endif
    <!-- [ Main Content ] start -->

@endsection

@section('styles')
    <link href="{{ asset('plugins/toolbar/css/jquery.toolbar.css') }}" rel="stylesheet">
@endsection

@section('script')
    <script src="{{ asset('plugins/toolbar/js/jquery.toolbar.min.js') }}"></script>
    <script src="{{ asset('js/pages/ac-toolbar.js') }}"></script>
@endsection

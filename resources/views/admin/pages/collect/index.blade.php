@extends('layouts.admin')
@section('content')
    <!-- [ Main Content ] start -->
    @if(!$results->isEmpty())
        @component('component.table',['items' => $items,'results' => $results,'target' => 'collect'])
            @slot('title')
                @if(!is_null($user))
                    用户 <span class="text-c-blue">{{ $user->name }}</span> 的@elseif(!is_null($order))
                    单号为 <span class="text-c-blue">{{ $order }}</span> 的@endif数据
            @endslot

            @foreach($results as $v)
                <tr>
                    <td><h6 class="m-0">{{ $loop->remaining+1 }}</h6></td>
                    <td><h6 class="m-0">{{ $v->order }}</h6></td>
                    <td>
                        <h6 class="m-0">
                            <a href="{{ route('admin.collect.user',[$v->user->id]) }}">{{ $v->user->name }}</a>
                        </h6>
                    </td>

                    <td><h6 class="m-0">{{ $v->type->name  }}</h6></td>

                    <td><h6 class="m-0 text-c-blue">{{ $v->total }}</h6></td>

                    <td><h6 class="m-0 text-c-blue">{{ $v->turnover->data }}</h6></td>

                    <td><h6 class="m-0">{{ date('Y-m-d',strtotime($v->turnover->created_at)) }}</h6></td>

                    <td>
                        <a class="text-white label bg-c-blue f-16 toolbar" href="#"
                           data-url="{{ route('admin.collect.update', [$v->id]) }}"
                           data-content="{{ $v->id }}">
                            <i class="icon feather icon-settings"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        @endcomponent
        <div id="toolbar-options" class="hidden">
            <a data-content="edit"><i class="feather icon-edit-2"></i></a>
            <a data-content="delete"><i class="feather icon-trash-2"></i></a>
        </div>
    @elseif(!is_null($order))
        <h2>不存在单号为<span class="text-c-red">{{ $order }}</span>的数据</h2>
    @else
        <div class="auth-wrapper offline">
            <div class="text-center">
                <h3 class="mb-4">还没有数据汇总</h3>
            </div>
        </div>
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

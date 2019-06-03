@extends('layouts.admin')
@section('content')
    <!-- [ Main Content ] start -->
    @if(!$results->isEmpty())
        @component('component.table',['items' => $items,'results' => $results,'target' => 'collect'])
            @slot('title')
                数据
            @endslot

            @foreach($results as $v)
                <tr>
                    <td><h6 class="m-0">{{ $v->id }}</h6></td>
                    <td>
                        <h6 class="m-0">
                            <a href="{{ route('admin.collect.user',[$v->user->id]) }}">{{ $v->user->name }}</a>
                        </h6>
                    </td>

                    <td><h6 class="m-0">@if($v->is_online)在线支付交易@else线下支付交易@endif</h6></td>

                    <td><h6 class="m-0 text-c-blue">{{ $v->data }}</h6></td>

                    <td><h6 class="m-0">{{ date('Y-m-d',strtotime($v->created_at)) }}</h6></td>

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

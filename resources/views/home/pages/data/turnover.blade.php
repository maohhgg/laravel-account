@extends('layouts.app')
@section('content')
    <!-- [ Main Content ] start -->
    @if(!$results->isEmpty())
        @component('component.table',['items' => $items,'results' => $results,'target'=> null])
            @slot('title')
                数据流水
            @endslot

            @foreach($results as $v)
                <tr>
                    <td><h6 class="m-0 text-c-purple">{{ $v->data }}</h6></td>
                    <td><h6 class="m-0 @if($v->type->type->action == 'income') text-c-green  @else text-c-red @endif">{{ $v->type->name.$v->description}}</h6></td>
                    <td><h6 class="m-0">{{ date('Y-m-d',strtotime($v->created_at)) }}</h6></td>
                </tr>
            @endforeach
        @endcomponent
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

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

                    <td><h6 class="m-0 @if($v->type->is_increase) text-c-green  @else text-c-red @endif">{{ $v->type->name}}</h6></td>
                    <td><h6 class="m-0 text-c-purple">{{ $v->description}}</h6></td>
                    <td>
                        @if($v->children)
                        <h6 class="m-0 @if($v->children->type->is_increase) text-c-green  @else text-c-red @endif">
                            {{ $v->children->type->name }}
                        </h6>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($v->children)
                            <h6 class="m-0 text-c-purple">
                                {{ $v->children->data }}
                            </h6>
                        @endif
                    </td>
                    <td>
                        @if($v->children)
                            <h6 class="m-0 text-c-purple">
                                @if($v->children->data == 0)
                                    0%
                                @else
                                    {{ round((abs($v->children->data)/$v->data)*100, 2) }}%
                                @endif
                            </h6>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($v->children)
                            <h6 class="m-0">
                                <i class="feather @if($v->children->data+$v->data > 0) icon-arrow-up text-c-green  @else icon-arrow-down text-c-red @endif"></i>
                                {{ $v->children->data+$v->data }}
                            </h6>
                        @else
                            <h6 class="m-0">
                                <i class="feather @if($v->data > 0) icon-arrow-up text-c-green  @else icon-arrow-down text-c-red @endif"></i>
                                {{ $v->data }}
                            </h6>
                        @endif
                    </td>
                    <td>
                        <h6 class="m-0 text-c-blue">
                            @if($v->children)
                                <i class="feather @if($v->children->history > 0) icon-arrow-up text-c-green  @else icon-arrow-down text-c-red @endif"></i>
                                {{ $v->children->history }}
                            @else
                                <i class="feather @if($v->history > 0) icon-arrow-up text-c-green  @else icon-arrow-down text-c-red @endif"></i>
                                {{ $v->history }}
                            @endif
                        </h6>
                    </td>

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

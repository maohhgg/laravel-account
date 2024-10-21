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

                    <td><h6 class="m-0">{{ date('Y-m-d',strtotime($v->created_at)) }}</h6></td>
                    <td><h6 class="m-0">{{ $v->type->name}}</h6></td>
                    <td><h6 class="m-0 text-c-purple">{{ sprintf('%0.2f',$v->data) }}</h6></td>

                    <td>
                        @if($v->tax)
                            <h6 class="m-0 text-c-purple">
                                @if($v->tax_rate == 0)
                                    0%
                                @else
                                    {{ sprintf('%0.2f', $v->tax_rate) }}%
                                @endif
                            </h6>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($v->third_tax)
                            <h6 class="m-0 text-c-red">{{ sprintf('%0.2f', $v->third_tax ) }}</h6>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($v->tax)
                            <h6 class="m-0 text-c-purple">
                                {{ sprintf('%0.2f',$v->tax) }}
                            </h6>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <h6 class="m-0 text-c-blue">
                            <h6 class="m-0 text-c-blue">
                                @if($v->tax)
                                    <i class="feather icon-arrow-down text-c-red"></i>
                                @else
                                    <i class="feather icon-arrow-up text-c-green"></i>
                                @endif
                                {{ sprintf('%0.2f',$v->history) }}
                            </h6>
                        </h6>
                    </td>


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

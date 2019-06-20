@extends('layouts.app')
@section('content')
    <!-- [ Main Content ] start -->
    @if($results->isEmpty() && $online_results->isEmpty())
        <div class="auth-wrapper offline">
            <div class="text-center">
                <h3 class="mb-4">还没有数据可以显示</h3>
            </div>
        </div>
    @endif

    <div class="row">
        @if(!$online_results->isEmpty())
            <div class="col-sm-12 col-md-6">
                @component('component.table',['items' => $items,'results' => $online_results,'target'=> null])
                    @slot('title')
                        在线交易汇总
                    @endslot

                    @foreach($online_results as $v)
                        <tr>
                            <td>
                                <h6 class="m-0 text-c-purple">
                                    @if (!is_null($v->collect))
                                        {{ $v->collect->total }}
                                    @else
                                        0
                                    @endif
                                </h6>
                            </td>
                            <td><h6 class="m-0">{{ date('Y-m-d',strtotime($v->created_at)) }}</h6></td>
                        </tr>
                    @endforeach
                @endcomponent
            </div>
        @endif


        @if(!$results->isEmpty())
            <div class="col-sm-12 col-md-6">
                @component('component.table',['items' => $items, 'results' => $results,'target'=> null])
                    @slot('title')
                        线下交易汇总
                    @endslot

                    @foreach($results as $v)
                        <tr>
                            <td>
                                <h6 class="m-0 text-c-purple">
                                    @if (!is_null($v->collect))
                                        {{ $v->collect->total }}
                                    @else
                                        0
                                    @endif
                                </h6>
                            </td>
                            <td><h6 class="m-0">{{ date('Y-m-d',strtotime($v->created_at)) }}</h6></td>
                        </tr>
                    @endforeach
                @endcomponent
            </div>
        @endif
    </div>
    <!-- [ Main Content ] start -->

@endsection

@section('styles')
    <link href="{{ asset('plugins/toolbar/css/jquery.toolbar.css') }}" rel="stylesheet">
@endsection

@section('script')
    <script src="{{ asset('plugins/toolbar/js/jquery.toolbar.min.js') }}"></script>
    <script src="{{ asset('js/pages/ac-toolbar.js') }}"></script>
@endsection

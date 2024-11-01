@extends('layouts.admin')
@section('content')
    <!-- [ Main Content ] start -->
    @if(!$results->isEmpty())
        @component('component.table',['items' => $items,'results' => $results,'target' => 'data', 'url' => 'admin.download.data'])
            @slot('title')
                数据
            @endslot
            @slot('confrimMessage')
                删除记录将会还原数据
            @endslot

            @foreach($results as $v)
                <tr>

                    <td><h6 class="m-0">{{ $v->id }}</h6></td>

                    <td>
                        <h6 class="m-0">
                            <a href="{{ route('admin.data.user',[$v->user->id]) }}">{{ $v->user->name }}</a>
                        </h6>
                    </td>

                    <td>
                        @if($v->tax_rate)
                            <h6 class="m-0 text-c-purple">{{ $v->type->name }}</h6>
                        @else
                            <h6 class="m-0 text-c-green">{{ $v->type->name }}</h6>
                        @endif
                    </td>


                    <td>
                        <h6 class="m-0 text-c-purple">
                            {{ sprintf('%0.2f', $v->data) }}
                        </h6>
                    </td>

                    <td>
                        @if($v->tax)
                            <h6 class="m-0 text-c-red">
                                {{ $v->taxType->name }}
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
                        @if($v->tax_rate)
                            <h6 class="m-0 text-c-red">{{ sprintf('%0.2f', $v->tax_rate ) }}%</h6>
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        @if($v->tax)
                            <h6 class="m-0">
                                <i class="feather icon-arrow-down text-c-red"></i>
                                {{ sprintf('%0.2f', $v->tax) }}
                            </h6>
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        <h6 class="m-0 text-c-blue">
                            @if($v->tax)
                                <i class="feather icon-arrow-down text-c-red"></i>
                            @else
                                <i class="feather icon-arrow-up text-c-green"></i>
                            @endif
                            {{ sprintf('%0.2f',$v->history) }}
                        </h6>
                    </td>

                    <td><h6 class="m-0">{{ $v->created_at }}</h6></td>

                    <td>
                        <a class="text-white label bg-c-blue f-16 toolbar" href="#"
                           data-url="{{ route('admin.data.update', [$v->id]) }}"
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

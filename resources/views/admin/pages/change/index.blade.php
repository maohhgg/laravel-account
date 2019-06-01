@extends('layouts.admin')
@section('content')

    <div class="row">
        @if($changeTypes)
            @foreach($changeTypes as $type)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-b-30">{{ $type->name }}</h5>
                        </div>
                        <div class="card-block task-setting">

                            @if(!$type->actions->isEmpty())
                                @foreach($type->actions as $action )
                                    <div class="row">
                                        <div class="col-sm-12 mb-3">
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                       id="changeAction{{ $action->id }}"
                                                       value="{{ $action->name }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary updateChangeType" type="button"
                                                            data-action="{{ $action->id }}" data-type="{{ $type->id }}">
                                                        更新
                                                    </button>
                                                    <button class="btn btn-danger deleteChangeType" type="button"
                                                            data-action="{{ $action->id }}" data-type="{{ $type->id }}">
                                                        删除
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <span> 还没有{{ $type->name }}, 请添加新的{{ $type->name }} </span>
                            @endif
{{--                            <div id="newChangeTypeBody{{ $type->id }}"></div>--}}
{{--                            <div style="display: none" id="defaultChangeTypeBody{{ $type->id }}">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-sm-12 mb-3">--}}
{{--                                        <div class="input-group">--}}
{{--                                            <input type="text" class="form-control" id="addAction{{ $type->id }}" placeholder="名称">--}}
{{--                                            <div class="input-group-append">--}}
{{--                                                <button class="btn btn-primary addChangeType" data-type="{{ $type->id }}" type="button">添加--}}
{{--                                                </button>--}}
{{--                                                <button class="btn btn-info cancelChangeType" data-type="{{ $type->id }}" type="button">取消--}}
{{--                                                </button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}


                            <div class="row text-center mt-2">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-primary  addChangeType"
                                            data-type="{{$type->id}}">
                                        添加新的{{ $type->name }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

@endsection

@section('script')

    <script src="{{ asset('js/pages/change-ajax.js') }}"></script>
    <script>
        const CSRFTOKEN = '{{ csrf_token() }}';
        const UPDATEURL = '{{ route('admin.change.save') }}';
        const DELETEURL = '{{ route('admin.change.delete') }}';
    </script>
@endsection
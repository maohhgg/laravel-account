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
                                                    @if($action->turnover->isEmpty())
                                                        <button class="btn btn-danger deleteChangeType" type="button"
                                                                data-action="{{ $action->id }}"
                                                                data-type="{{ $type->id }}">
                                                            删除
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <span> 还没有{{ $type->name }}, 请添加新的{{ $type->name }} </span>
                            @endif

                            <div class="row text-center mt-2">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-primary addChangeType"
                                            data-type="{{$type->id}}" data-type-name="{{$type->name}}">
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

    <div class="modal fade" id="createActionModal" tabindex="-1" role="dialog" aria-labelledby="actionModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">添加新<span id="actionModalLabel" class="text-c-blue"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="create-change-form" action="{{ route('admin.change.create') }}">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="change_type_id" id="change-type-id">
                            <label for="recipient-name" class="col-form-label">名称</label>
                            <input name="name" type="text"
                                   class="form-control tooltip-test @error('name') border-danger @enderror"
                                   placeholder="充值"
                                   @error('name') data-toggle="tooltip" data-placement="top" data-container="#createActionModal"
                                   title="{{ $message }}" @enderror
                                   value="{{ old('name') }}" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" data-dismiss="modal">取消</button>
                    <button href="{{ URL::current() }}"
                            onclick="event.preventDefault();document.getElementById('create-change-form').submit();"
                            type="button"
                            class="btn btn-primary">添加
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('js/pages/change-ajax.js') }}"></script>
    <script>
        const CSRFTOKEN = '{{ csrf_token() }}';
        const UPDATEURL = '{{ route('admin.change.save') }}';
        const DELETEURL = '{{ route('admin.change.delete') }}';
        $(document).ready(function () {
            @error('name')
            $('#createActionModal').modal('show');
            $('#actionModalLabel').html(this.getAttribute('data-type-name'));
            @enderror
        })
    </script>
@endsection
@extends('layouts.admin')
@section('content')

    <div class="row">
        @if($types)
            @foreach($types as $key =>  $item)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-b-30">{{  $key }}</h5>
                        </div>
                        <div class="card-block task-setting">

                            @if($item)
                                @foreach($item as $k => $v )
                                    <div class="row">
                                        <div class="col-sm-12 mb-3">
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                       id="changeAction{{ $k }}"
                                                       value="{{ $v }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary updateChangeType" type="button" data-type="{{ $k }}">
                                                        重命名
                                                    </button>

{{--                                                    <button class="btn btn-danger deleteChangeType" type="button" data-type="{{ $v }}">--}}
{{--                                                        删除--}}
{{--                                                    </button>--}}

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <span> 还没有{{ $key }}, 请添加新的{{ $key }} </span>
                            @endif

                            <div class="row text-center mt-2">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-primary addChangeType" data-type="{{$key=='收入方式' ? 1 : 0}}" data-type-name="{{$key}}">
                                        添加新的{{ $key }}
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
                            <input type="hidden" name="is_increase" id="change-type-id">
                            <label for="recipient-name" class="col-form-label">名称</label>
                            <input name="name" type="text"
                                   class="form-control tooltip-test @error('name') border-danger @enderror"
                                   placeholder="名称"
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

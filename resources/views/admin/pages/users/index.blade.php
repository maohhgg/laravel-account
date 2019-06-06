@extends('layouts.admin')
@section('content')
    <!-- [ Main Content ] start -->
    @if(!$results->isEmpty())
        @component('component.table',['items' => $items, 'results' => $results,'target' => 'users'])
            @slot('title')
                用户数据
            @endslot

            @slot('otherModal')
                <div class="modal fade" id="createTurnoverModal" tabindex="-1" role="dialog"
                     aria-labelledby="createTurnoverModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">添加新数据</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">用户</label>

                                    {{ Form::hidden('',null,['id'=>'turnover-user-id']) }}
                                    {{ Form::text('',null,['id'=>'turnover-user','class'=>'form-control','disabled']) }}

                                </div>
                                <div class="form-group">
                                    <label class="form-label">类型</label>
                                    {{ Form::select('user_id', $actionTypes, null, ['id'=>'turnover-type-id','class'=>'js-data-ajax form-control']) }}
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        详细
                                        <small>为类型的补充，和类型一起显示(<span class="text-c-red">* 可以为空</span>)</small>
                                    </label>
                                    {{ Form::text('description',null,['id'=>'turnover-description','class'=>'form-control','placeholder'=>'添加描述']) }}
                                </div>

                                <div class="form-group">
                                    <label class="form-label">数值</label>
                                    {{ Form::number('data',null,['id'=>'turnover-data','class'=>'form-control']) }}
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-info" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-primary" id="createTurnoverButton">添加</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="createCollectModal" tabindex="-1" role="dialog"
                     aria-labelledby="createCollectModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">添加新汇总数据</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">用户</label>

                                    {{ Form::hidden('',null,['id'=>'collect-user-id']) }}
                                    {{ Form::text('',null,['id'=>'collect-user','class'=>'form-control','disabled']) }}

                                </div>
                                <div class="form-group">
                                    <label class="form-label">类型</label>
                                    {{ Form::select('is_online', $collectTypes, null, ['id'=>'collect-type-id','class'=>'js-data-ajax form-control']) }}
                                </div>

                                <div class="form-group">
                                    <label class="form-label">数值</label>
                                    {{ Form::number('data',null,['id'=>'collect-data','class'=>'form-control']) }}
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label">日期</label>
                                    {{ Form::date('created_at', date('Y-m-d',strtotime('-1 day')),['class'=>'form-control','id' => 'collect-date']) }}
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-info" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-primary" id="createCollectButton">添加</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endslot

            @foreach($results as $v)
                <tr>
                    <td><h6 class="m-0">{{ $loop->iteration }}</h6></td>
                    <td><h6 class="m-0">{{ $v->id }}</h6></td>
                    <td><h6 class="m-0">{{ $v->name }}</h6></td>
                    <td><h6 class="m-0">@if($v->phoneDefault()) 未添加 @else {{ $v->phone }} @endif</h6></td>
                    <td><h6 class="m-0">{{ $v->balance }}</h6></td>
                    <td><h6 class="m-0">@if($v->emailDefault()) 未添加 @else {{ $v->email }} @endif</h6></td>

                    <td><h6 class="m-0">{{ $v->created_at->format('Y-m-d') }}</h6></td>
                    <td><h6 class="m-0">{{ $v->updated_at->format('Y-m-d') }}</h6></td>
                    <td>
                        <a class="text-white label bg-c-blue f-16 toolbar"
                           data-user-id=" {{ $v->id }}"
                           data-url="{{ route('admin.users.update', [$v->id]) }}"
                           data-data-url="{{ route('admin.data.create', [$v->id]) }}"
                           data-content="{{ $v->id }}" data-name="{{ $v->name }}">
                            <i class="icon feather icon-settings"></i>
                        </a>
                    </td>
                </tr>
            @endforeach


        @endcomponent

        <div id="toolbar-options" class="hidden">
            <a data-content="edit"><i class="feather icon-edit-2"></i></a>
            <a data-content="push"><i class="feather icon-plus-circle"></i></a>
            <a data-content="collect"><i class="feather icon-file-plus"></i></a>
            <a data-content="delete"><i class="feather icon-trash-2"></i></a>
        </div>
    @else
        <div class="auth-wrapper offline">
            <div class="text-center">
                <h3 class="mb-4">还没有会员</h3>
            </div>
        </div>
    @endif
    <!-- [ Main Content ] start -->
@endsection


@section('styles')
    <link href="{{ asset('plugins/toolbar/css/jquery.toolbar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection


@section('script')

    <script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.min.js') }}"></script>
    <script src="{{ asset('plugins/toolbar/js/jquery.toolbar.min.js') }}"></script>
    <script src="{{ asset('js/pages/ac-toolbar.js') }}"></script>
    <script>
        const CSRFTOKEN = '{{ csrf_token() }}';
        const DATAADDURL = '{{ route('admin.data.add') }}';
        const COLLECTADDURL = '{{ route('admin.collect.add') }}';

        function toastMessage(string) {
            $('#toast-message').html(string);
            $('.toast').toast('show');
        }

        $(document).ready(function () {
            $('#collect-date').datepicker({
                language: 'zh-CN',
                autoclose: true
            });

            $('#createCollectButton').click(function () {
                let data = {
                    '_token': CSRFTOKEN,
                    'user_id': $('#collect-user-id').val(),
                    'is_online': $('#collect-type-id').find(":selected").val(),
                    'data': $('#collect-data').val(),
                    'created_at': $('#collect-date').val(),
                    'method': 'ajax'
                };

                $.post(COLLECTADDURL, data).done(function (result) {
                    window.location.reload();
                }).fail(function (result) {
                    toastMessage('请填写必须项');
                });

            });

            $('#createTurnoverButton').click(function () {
                let data = {
                    '_token': CSRFTOKEN,
                    'user_id': $('#turnover-user-id').val(),
                    'type_id': $('#turnover-type-id').find(":selected").val(),
                    'data': $('#turnover-data').val(),
                    'method': 'ajax'
                };
                let desc = $('#turnover-description').val();
                if (desc) {
                    data.description = desc
                }

                $.post(DATAADDURL, data).done(function (result) {
                    window.location.reload();
                }).fail(function (result) {
                    toastMessage('请填写必须项');
                });
            })
        })
    </script>
@endsection

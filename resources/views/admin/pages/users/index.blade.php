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
                                    <input name="exist_extend" type="hidden" id="exist_extend" value="1">
                                    {{ Form::hidden('',null,['id'=>'turnover-user-id']) }}
                                    {{ Form::text('',null,['id'=>'turnover-user','class'=>'form-control','disabled']) }}

                                </div>
                                <div class="form-group">
                                    <label class="form-label">类型</label>
                                    {{ Form::select('user_id', $types, null, ['id'=>'turnover-type-id','class'=>'js-data-ajax form-control']) }}
                                </div>


                                <div class="form-group">
                                    <label class="form-label">金额</label>
                                    {{ Form::number('data',null,['id'=>'turnover-data','class'=>'form-control','min'=>'0.001','step'=>'0.001']) }}
                                </div>

                                <div class="form-group"  id="extend_content">
                                    <label class="form-label">手续费 费率</label>
                                    <div class="input-group">
                                        {{ Form::number('tax_rate',null,['id'=>'tax_rate','class'=>'form-control','min'=>'0.01','max'=> '100','step'=>'0.01']) }}
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-info" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-primary" id="createTurnoverButton">添加</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endslot

            @foreach($results as $v)
                <tr>
                    @foreach($items as $key =>  $item)
                        @if($key == 'avatar')
                            <td>
                                <img class="rounded-circle" style="width:40px;"
                                     src="{{ asset('images/user/'.$v->icon) }}" alt="activity-user">
                            </td>
                        @elseif($key == 'balance')
                            <td><h6 class="m-0">{{ sprintf('%0.2f',$v->{$key}) }}</h6></td>
                        @elseif($key == 'action')
                            <td>
                                <a class="text-white label bg-c-blue f-16 toolbar"
                                   data-user-id=" {{ $v->id }}"
                                   data-url="{{ route('admin.users.update', [$v->id]) }}"
                                   data-data-url="{{ route('admin.data.create', [$v->id]) }}"
                                   data-content="{{ $v->id }}" data-name="{{ $v->name }}">
                                    <i class="icon feather icon-settings"></i>
                                </a>
                            </td>
                        @elseif(strpos($key, 'created_at') !== false)
                            <td><h6 class="m-0">{{ $v->created_at->format('Y-m-d') }}</h6></td>
                        @elseif(strpos($key, 'updated_at') !== false)
                            <td><h6 class="m-0">{{ $v->updated_at->format('Y-m-d') }}</h6></td>
                        @elseif(strpos($key, 'name') !== false)
                            <td>
                                <h6 class="m-0">
                                    <a href="{{ route('admin.data.user',[$v->id]) }}">{{ $v->name }}</a>
                                </h6>
                            </td>
                        @else
                            <td><h6 class="m-0">{{ $v->{$key} }}</h6></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach



        @endcomponent

        <div id="toolbar-options" class="hidden">
            <a data-content="edit"><i class="feather icon-edit-2"></i></a>
            <a data-content="push"><i class="feather icon-plus-circle"></i></a>
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
    <script>

        let hidden = function (){
            $('#extend_content').css("display","none");
        }
        let show = function () {
            $('#extend_content').css("display","block");
        }

        const CSRFTOKEN = '{{ csrf_token() }}';
        const ADDURL = '{{ route('admin.data.add') }}';

        $(document).ready(function () {
            $('#turnover-type-id').on('change', function() {
                if($(this).find(":selected").val() === 1){
                    hidden();
                    $("#exist_extend").attr('value', 1);
                } else {
                    show();
                    $("#exist_extend").attr('value', 0);
                }
            });

            $('#createTurnoverButton').click(function () {
                $('#createTurnoverButton').attr('disabled');
                let data = {
                    '_token': CSRFTOKEN,
                    'user_id': $('#turnover-user-id').val(),
                    'type_id': $('#turnover-type-id').find(":selected").val(),
                    'data': $('#turnover-data').val(),
                    'tax_rate': $('#tax_rate').val(),
                    'method': 'ajax'
                };
                let desc = $('#turnover-description').val();
                if (desc) {
                    data.description = desc;
                }

                $.post(
                    ADDURL,
                    data
                ).done(function () {
                    window.location.reload();
                });
            })
        })
    </script>
@endsection

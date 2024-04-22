@extends('layouts.admin')
@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>创建新的数据流</h5>
                    <span class="d-block m-t-5">编辑 <code>数据</code> 信息</span>
                </div>
                <div class="card-block">
                    <form action="@if($results) {{ route('admin.data.save') }} @else {{ route('admin.data.add') }} @endif"
                          method="post">
                        @csrf
                        {{  Form::hidden('url',URL::previous())  }}

                        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                            @if($results) {{  Form::hidden('id', $results->id)  }} @endif
                            @if($results && $results->children)
                                <input name="exist_extend" type="hidden" id="exist_extend" value="{{ $results->children->id }}">
                                <input name="extend_id" type="hidden" id="extend_id" value="{{ $results->children->id }}">
                            @else
                                <input name="exist_extend" type="hidden" id="exist_extend" value="0">
                            @endif

                            <div class="form-group " @error('user_id') data-toggle="tooltip" data-placement="top" title="{{ $message }}" @enderror>
                                <label class="form-label">用户</label>
                                @if($user)
                                    {{  Form::hidden('user_id',$user->id )  }}
                                    {{  Form::text(null, $user->name, array('class'=>'form-control','disabled')) }}
                                @else
                                    {{ Form::select('user_id', [], null, ['placeholder' => '用户','class'=>'js-data-ajax col-sm-12']) }}
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="form-label">类型</label>
                                @if($results)
                                    {{ Form::select('type_id', $types, $results->type_id, ['class'=>'js-data-single  form-control']) }}
                                @else
                                    {{ Form::select('type_id', $types, null, ['class'=>'js-data-single  form-control']) }}
                                @endif
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">
                                    补充说明 <span>(如 微信扫码、刷卡 <span class="text-c-red">可以为空</span>)</span>
                                </label>
                                <input name="description" type="text" class="form-control"
                                       value="@if(!$results){{ old('description') }}@else{{$results->description }}@endif"
                                       placeholder="添加描述"/>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">数值</label>
                                <input name="data" type="number"
                                       class="form-control  @error('data') border-danger @enderror" min="0.01"
                                       @error('data') data-toggle="tooltip" data-placement="top"
                                       title="{{ $message }}" @enderror
                                       value="@if(!$results){{ old('data') }}@else{{ abs(floatval($results->data)) }}@endif"
                                       step="0.01"/>
                            </div>

                            <div class="form-group mb-4"  id="extend_content" style="display: none">
                                <label class="form-label">额外信息</label>
                                <div class="form-group">
                                    <label class="form-label">类型</label>
                                    @if($results && $results->children)
                                        {{ Form::select('extend_type_id', $types, $results->children->type_id, ['class'=>'js-data-single  form-control']) }}
                                    @else
                                        {{ Form::select('extend_type_id', $types, null, ['class'=>'js-data-single  form-control']) }}
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-label">数值</label>
                                    <input name="extend_data" type="number"
                                           class="form-control  @error('extend_data') border-danger @enderror" min="0.01"
                                           @error('extend_data') data-toggle="tooltip" data-placement="top"
                                           title="{{ $message }}" @enderror
                                           value="@if(!$results){{ old('extend_data') }}@elseif($results->children){{ abs(floatval($results->children->data)) }}@endif"
                                           step="0.01"/>
                                </div>
                            </div>


                                <button type="submit" class="btn btn-primary">@if($results) 更新 @else 创建 @endif</button>
                                <button type="button" class="btn btn-success" id="extend_button">添加额外信息</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

@section('script')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        let hidden = function (){
            $('#extend_content').css("display","none");
            $('#extend_button').attr('class',"btn btn-warning");
            $('#extend_button').html("添加额外信息")
        }
        let show = function () {
            $('#extend_content').css("display","block");
            $('#extend_button').attr('class',"btn btn-success");
            $('#extend_button').html("删除额外信息")
        }

        let fun = function(){
            exist = $("#exist_extend").attr('value');
            if(exist == 1){
                hidden()
                $("#exist_extend").attr('value', 0);
            } else {
                show();
                $("#exist_extend").attr('value', 1);
            }
        }

        $(document).ready(function () {
            exist = $("#exist_extend").attr('value');
            if(exist != 0){
                show()
            } else {
                hidden();
            }

            $("#extend_button").click(fun)

            $(".js-data-ajax").select2({
                ajax: {
                    url: "{{ route('users.autocomplete') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            query: params.term
                        };
                    },

                    processResults: function (data, params) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@endsection

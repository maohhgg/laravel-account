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

                            <div class="form-group " @error('user_id') data-toggle="tooltip" data-placement="top"
                                 title="{{ $message }}" @enderror>
                                <label class="form-label">用户
                                    @error('user_id')
                                    <h6 class="text-c-red"> {{ $message }}</h6>
                                    @enderror
                                </label>
                                @if($user)
                                    {{  Form::hidden('user_id',$user->id )  }}
                                    {{  Form::text(null, $user->name, array('class'=>'form-control','disabled')) }}
                                @else
                                    {{ Form::select('user_id', [], null, ['placeholder' => '选择一个用户','class'=>'js-data-ajax col-sm-12']) }}
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
                                    详细
                                    <small>为类型的补充，和类型一起显示(<span class="text-c-red">* 可以为空</span>)</small>
                                </label>
                                <input name="description" type="text" class="form-control"
                                       value="@if(!$results){{ old('description') }}@else{{$results->description }}@endif"
                                       placeholder="添加描述"/>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">数值</label>
                                <input name="data" type="number" step="0.01"
                                       class="form-control  @error('data') border-danger @enderror"
                                       @error('data') data-toggle="tooltip" data-placement="top"
                                       title="{{ $message }}" @enderror
                                       value="@if(!$results){{ old('data') }}@else{{ floatval($results->data) }}@endif"/>
                            </div>

                            @if($results)
                                <div class="form-group mb-4">
                                    <label class="form-label">数值</label>
                                    {{ Form::date('created_at', date('Y-m-d', strtotime($results->created_at)),
                                    ['class'=>'form-control','id'=>'datepicker']) }}
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary">@if($results) 更新 @else 创建 @endif</button>
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
    @if($results)
        <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    @endif
@endsection

@section('script')
    @if($results)
        <script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.min.js') }}"></script>
    @endif
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            @if($results)
            $('#datepicker').datepicker({
                language:  'zh-CN',
                autoclose: true
            });
            @endif

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

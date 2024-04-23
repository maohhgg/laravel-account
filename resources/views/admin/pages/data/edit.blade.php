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

                        <div class="col-12 col-xl-6">
                            @if($results) {{  Form::hidden('id', $results->id)  }} @endif

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
                                    {{ Form::select('type_id', $types, $results->type_id, ['id'=> 'type_id','class'=>'js-data-single  form-control']) }}
                                @else
                                    {{ Form::select('type_id', $types, null, ['id'=> 'type_id','class'=>'js-data-single  form-control']) }}
                                @endif
                            </div>


                            <div class="form-group">
                                <label class="form-label">金额</label>
                                <input name="data" type="number"
                                       class="form-control  @error('data') border-danger @enderror" min="0.001"
                                       @error('data') data-toggle="tooltip" data-placement="top"
                                       title="{{ $message }}" @enderror
                                       value="@if(!$results){{ old('data') }}@else{{ abs(floatval($results->data)) }}@endif"
                                       step="0.001"/>
                            </div>

                            <div class="form-group"  id="extend_content">
                                <label class="form-label">手续费 费率</label>
                                <div class="input-group">
                                    <input
                                        name="tax_rate"
                                        type="number"
                                        class="form-control @error('extend_data') border-danger @enderror"
                                        min="0.01"
                                        max="100"
                                        @error('extend_data') data-toggle="tooltip" data-placement="top" title="{{ $message }}" @enderror
                                        value="@if(!$results){{ old('extend_data') }}@elseif($results->dtax_rate>0){{ $results->dtax_rate * 100 }}@endif"
                                        step="0.01"
                                    />
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>


                            </div>


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
@endsection

@section('script')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function () {

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

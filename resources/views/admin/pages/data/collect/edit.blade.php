@extends('layouts.admin')
@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>创建新的汇总</h5>
                    <span class="d-block m-t-5">编辑 <code>汇总</code> 信息</span>
                </div>
                <div class="card-block">
                    <form action=" {{ route('admin.data.collect.add') }}"
                          method="post">
                        @csrf
                        {{  Form::hidden('url',URL::previous())  }}

                        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">

                            <div class="form-group">
                                <label class="form-label">用户
                                    @error('user_id')
                                    <h6 class="text-c-red"> {{ $message }}</h6>
                                    @enderror
                                </label>
                                @if(isset($user))
                                    {{  Form::hidden('user_id',$user->id )  }}
                                    {{  Form::text(null, $results->user->id, array('class'=>'form-control','disabled')) }}
                                @else
                                    {{ Form::select('user_id', [], null, ['placeholder' => '选择一个用户','class'=>'js-data-ajax col-sm-12']) }}
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="form-label">类型</label>
                                {{ Form::select('is_online', $types, null, ['class'=>'js-data-single  form-control']) }}
                            </div>

                            <div class="form-group">
                                <label class="form-label">汇总补差金额数值</label>
                                <input name="data" type="number" step="0.01"
                                       class="form-control  @error('data') border-danger @enderror"
                                       @error('data') data-toggle="tooltip" data-placement="top"
                                       title="{{ $message }}" @enderror
                                       value="@if(isset($results)){{ floatval($results->data) }}@else{{ old('data') }}@endif"/>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">日期</label>
                                <input name="created_at" type="date" id="datepicker"
                                       class="form-control  @error('created_at') border-danger @enderror"
                                       @error('created_at') data-toggle="tooltip" data-placement="top"
                                       title="{{ $message }}" @enderror
                                       value="@if(isset($result)) {{ date('Y-m-d',strtotime($results->created_at)) }}@else{{ old('created_at') ?? date('Y-m-d',strtotime('-1 day')) }}@endif"
                                />
                            </div>

                            <button type="submit" class="btn btn-primary">创建</button>
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
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection

@section('script')

    <script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#datepicker').datepicker({
                language: 'zh-CN',
                autoclose: true
            });

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

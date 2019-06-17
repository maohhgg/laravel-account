@extends('layouts.admin')
@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>服务器信息</h5>
                    <span class="d-block m-t-5">编辑 <code>服务器</code> 信息</span>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-5 col-xl-4 mb-3">
                            <form action="{{ route('admin.config.save') }}" method="post">
                                @csrf
                                {{  Form::hidden('url',URL::previous())  }}

                                @foreach($results as $item)
                                    @if($item->key != $diff)
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ $item->name }}</label>
                                            <input name="{{ $item->key }}" type="text"
                                                   class="form-control @error($item->key) border-danger @enderror"
                                                   @error($item->key) data-toggle="tooltip" data-placement="top"
                                                   title="{{ $message }}" @enderror
                                                   value="{{ old($item->key) ?? $item->value }}" required>
                                        </div>
                                    @else
                                        <div class="form-group mb-3">
                                            <div class="switch d-inline m-r-10">
                                                {{  Form::hidden($item->key, $item->value, ['id'=>'check-status'])  }}
                                                <input id="switch-button" type="checkbox"
                                                       @if($item->value == 1) checked @endif>
                                                <label for="switch-button" class="cr"></label>
                                            </div>
                                            <label>是否开启在线充值</label>
                                        </div>
                                    @endif
                                @endforeach

                                <button type="submit" class="btn btn-primary">更新</button>
                            </form>
                        </div>
                        <div class="col-12 col-md-6 col-lg-5 col-xl-4">
                            <form action="{{ route('admin.backup') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label class="text-c-red">数据备份</label>
                                    {{ Form::select('database', ['users' => '用户数据','recharge_orders'=>'充值记录','turnovers'=>'交易数据'], null, ['class'=>'js-data-single  form-control']) }}
                                </div>
                                <button class="btn btn-info" type="submit">下载备份文件</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

@endsection
@section('styles')
    <link href="{{ asset('plugins/fileupload/css/fileupload.css') }}">
@endsection
@section('script')
    <script src="{{ asset('plugins/fileupload/js/dropzone-amd-module.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#switch-button").click(function () {
                console.log($(this).prop("checked"));
                if ($(this).prop("checked")) {
                    $('#check-status').val(1)
                } else {
                    $('#check-status').val(0)
                }
            })
        })
    </script>
@endsection
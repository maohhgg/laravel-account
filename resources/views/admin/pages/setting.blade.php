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
                    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                        <form action="{{ route('admin.config.save') }}" method="post">
                            @csrf
                            {{  Form::hidden('url',URL::previous())  }}

                            @foreach($results as $key => $item)
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ $item['name'] }}</label>
                                    <input name="{{ $key }}" type="text"
                                           class="form-control @error($key) border-danger @enderror"
                                           @error($key) data-toggle="tooltip" data-placement="top"
                                           title="{{ $message }}" @enderror
                                           value="{{ old($key) ?? $item['value'] }}" required>
                                </div>
                            @endforeach

                            <button type="submit" class="btn btn-primary">更新</button>
                        </form>
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
@endsection
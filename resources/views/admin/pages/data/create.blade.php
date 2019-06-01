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
                    <form action="{{ route('admin.data.create') }}" method="post">
                        @csrf
                        @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('type_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('data')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">

                            <div class="form-group">
                                <label class="form-label">用户</label>
                                @if($user)
                                    <select name="user_id" class="col-sm-12 form-control">
                                        <option value="{{ $user->id }}" selected="selected"> {{ $user->name }}</option>
                                    </select>
                                @else
                                    <select name="user_id" class="js-data-ajax col-sm-12">
                                        <option value="" selected="selected">请选择用户</option>
                                    </select>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="form-label">类型</label>
                                <select name="type_id" class="js-basic-single form-control">
                                    @if($changeTypes)
                                        @foreach($changeTypes as $type)
                                            <optgroup label="{{ $type->name }}">
                                                @if(!$type->actions->isEmpty())
                                                    @foreach($type->actions as $action )
                                                        <option value="{{ $action->id }}">{{ $action->name }}</option>
                                                    @endforeach
                                                @endif
                                            </optgroup>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">描述
                                    <small>(<span class="text-c-red">可以为空</span>)</small>
                                </label>
                                <input name="detail" type="text" class="form-control" value="{{ old('detail') }}"
                                       placeholder="添加描述"/>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">数值</label>
                                <input name="data" type="number" class="form-control" min="0.01"
                                       value="{{ old('data') }}"
                                       step="0.01"/>
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

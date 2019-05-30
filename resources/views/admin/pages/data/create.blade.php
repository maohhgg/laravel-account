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

                        <div class="row form-group">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                                <div class="form-group">
                                    <label class="form-label">名称</label>
                                    <input type="text" name="name" class="typeahead form-control" placeholder="example">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">创建</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

@endsection

@section('script')
    <script src="{{ asset('plugins/typeahead/typeahead.min.js') }}"></script>
    <script>
        const bestPictures = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '{{ route('users.autocomplete') }}',
                wildcard: '%QUERY'
            }
        });

        $('#remote .typeahead').typeahead(null, {
            name: 'best-pictures',
            display: 'value',
            source: bestPictures
        });
    </script>
@endsection
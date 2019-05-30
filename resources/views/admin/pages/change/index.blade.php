@extends('layouts.admin')
@section('content')
    <div class="row">
        @if($changeTypes)
            @foreach($changeTypes as $type)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-block">
                            <h5 class="m-b-30">{{ $type->name }}</h5>
                            @if(!$type->actions->isEmpty())
                                @foreach($type->actions as $action )
                                    <div class="media summary-box mb-4">
                                        <div class="photo-table">
                                            <h4 class="m-0 f-w-300">
                                                <span>{{ $action->name }}</span>
                                            </h4>
                                        </div>
                                        <div class="media-body">
                                            <i class="card-icon float-right f-20 feather icon-{{ $type->icon }}"></i>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <span> 请添加新的{{ $type->name }} </span>
                            @endif


                            <div class="form-group">
                                <a href="#!" class="btn btn-primary shadow-2 text-uppercase btn-block"
                                   style="max-width:150px;margin:0 auto;">添加{{ $type->name }}</a>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
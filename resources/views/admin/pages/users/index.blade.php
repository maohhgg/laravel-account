@extends('layouts.admin')
@section('content')
    <!-- [ Main Content ] start -->
    @if(!$results->isEmpty())
        @component('component.table',['items' => $items, 'results' => $results,'target' => 'users'])
            @slot('title')
                用户数据
            @endslot

            @foreach($results as $v)
                <tr>
                    <td><h6 class="m-0">{{ $loop->iteration }}</h6></td>
                    <td><h6 class="m-0">{{ $v->id }}</h6></td>
                    <td><h6 class="m-0 text-c-blue">{{ $v->name }}</h6></td>
                    <td><h6 class="m-0">@if($v->phoneDefault()) 未添加 @else {{ $v->phone }} @endif</h6></td>
                    <td><h6 class="m-0 text-c-yellow">{{ $v->balance }}</h6></td>
                    <td><h6 class="m-0">@if($v->emailDefault()) 未添加 @else {{ $v->email }} @endif</h6></td>

                    <td><h6 class="m-0">{{ $v->created_at->format('Y-m-d') }}</h6></td>
                    <td><h6 class="m-0">{{ $v->updated_at->format('Y-m-d') }}</h6></td>
                    <td>
                        <a class="text-white label bg-c-blue f-16 toolbar"
                           data-user-id=" {{ $v->id }}"
                           data-url="{{ route('admin.users.update', [$v->id]) }}"
                           data-data-url="{{ route('admin.data.create', [$v->id]) }}"
                           data-collect-url="{{ route('admin.collect.create', [$v->id]) }}"
                           data-content="{{ $v->id }}" data-name="{{ $v->name }}">
                            <i class="icon feather icon-settings"></i>
                        </a>
                    </td>
                </tr>
            @endforeach


        @endcomponent

        <div id="toolbar-options" class="hidden">
            <a data-content="edit"><i class="feather icon-edit-2"></i></a>
            <a data-content="push"><i class="feather icon-plus-circle"></i></a>
            <a data-content="collect"><i class="feather icon-file-plus"></i></a>
            <a data-content="delete"><i class="feather icon-trash-2"></i></a>
        </div>
    @else
        <div class="auth-wrapper offline">
            <div class="text-center">
                <h3 class="mb-4">还没有会员</h3>
            </div>
        </div>
    @endif
    <!-- [ Main Content ] start -->
@endsection


@section('styles')
    <link href="{{ asset('plugins/toolbar/css/jquery.toolbar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection


@section('script')

    <script src="{{ asset('plugins/toolbar/js/jquery.toolbar.min.js') }}"></script>
    <script src="{{ asset('js/pages/ac-toolbar.js') }}"></script>

@endsection

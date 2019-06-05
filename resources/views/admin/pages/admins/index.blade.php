@extends('layouts.admin')
@section('content')
    <!-- [ Main Content ] start -->
    @if(!$results->isEmpty())
        @component('component.table',['items' => $items, 'results' => $results,'target' => 'admins'])
            @slot('title')
                管理员数据
            @endslot

            @foreach($results as $v)
                <tr>
                    <td><h6 class="m-0">{{ $v->id }}</h6></td>
                    <td><h6 class="m-0">{{ $v->name }}</h6></td>
                    <td><h6 class="m-0">{{ $v->email }}</h6></td>
                    <td><h6 class="m-0">{{ $v->created_at->format('Y-m-d') }}</h6></td>
                    <td><h6 class="m-0">{{ $v->updated_at->format('Y-m-d') }}</h6></td>
                    <td>
                        <a class="text-white label bg-c-blue f-16 toolbar"
                           data-url="{{ route('admin.admins.update', [$v->id]) }}"
                           data-content="{{ $v->id }}" data-name="{{ $v->name }}">
                            <i class="icon feather icon-settings"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        @endcomponent

        <div id="toolbar-options" class="hidden">
            <a data-content="edit"><i class="feather icon-edit-2"></i></a>
            <a data-content="delete"><i class="feather icon-trash-2"></i></a>
        </div>

    @else
        还没有数据
    @endif
    <!-- [ Main Content ] start -->
@endsection


@section('styles')
    <link href="{{ asset('plugins/toolbar/css/jquery.toolbar.css') }}" rel="stylesheet">
@endsection

@section('script')
    <script src="{{ asset('plugins/toolbar/js/jquery.toolbar.min.js') }}"></script>
    <script src="{{ asset('js/pages/ac-toolbar.js') }}"></script>
@endsection

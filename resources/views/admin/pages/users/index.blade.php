@extends('layouts.admin')
@section('content')
    <!-- [ Main Content ] start -->
    @if($results)
        @component('component.table',['items' => $items, 'results' => $results,'target' => 'users'])
            @slot('title')
                用户数据
            @endslot

            @foreach($results as $v)
                <tr>
                    @foreach($items as $key =>  $item)
                        @if($key == 'avatar')
                            <td>
                            <td>
                                <img class="rounded-circle" style="width:40px;"
                                     src="{{ asset('images/user/'.$v->icon) }}" alt="activity-user">
                            </td>
                        @elseif($key == 'action')
                            <td>
                                <a class="text-white label bg-c-blue f-16 toolbar"
                                   data-url = "{{ route('admin.users.update', [$v->id]) }}"
                                   data-data-url = "{{ route('admin.data.create', [$v->id]) }}"
                                   data-content="{{ $v->id }}" data-name="{{ $v->name }}">
                                    <i class="icon feather icon-settings"></i>
                                </a>
                            </td>
                        @elseif(strpos($key, 'created_at') !== false)
                            <td><h6 class="m-0">{{ $v->created_at->format('Y-m-d') }}</h6></td>
                        @elseif(strpos($key, 'updated_at') !== false)
                            <td><h6 class="m-0">{{ $v->updated_at->format('Y-m-d') }}</h6></td>
                        @else
                            <td><h6 class="m-0">{{ $v->{$key} }}</h6></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        @endcomponent

        <div id="toolbar-options" class="hidden">
            <a data-content="edit"><i class="feather icon-edit-2"></i></a>
            <a data-content="push"><i class="feather icon-plus-circle"></i></a>
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

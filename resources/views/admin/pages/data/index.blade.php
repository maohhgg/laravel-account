@extends('layouts.admin')
@section('content')
    @if($data)
    @component('admin.component.table',['items' => $showItem])
        @slot('title')
            数据流水
        @endslot



            @foreach($data as $v)
                <tr>
                    @foreach($items as $key =>  $item)
                        @if($key == 'avatar')
                            <td>
                                <img class="rounded-circle" style="width:40px;"
                                     src="{{ asset('images/user/'.$v->user->icon) }}" alt="activity-user">
                            </td>
                        @elseif($key == 'action')
                            <td class="">
                                <a class="text-white label bg-c-blue f-16 toolbar" href="#"
                                   data-content="{{ $v->id }}">
                                    <i class="icon feather icon-settings"></i>
                                </a>
                            </td>
                        @elseif(strpos($key, 'ated_at') !== false)
                            <td><h6 class="m-0">{{ $v->{$key}->format('Y-m-d') }}</h6></td>
                        @else
                            <td><h6 class="m-0">{{ $v->{$key} }}</h6></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
    @endcomponent

    @else
        还没有数据
    @endif
@endsection
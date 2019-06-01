<div class="card User-Activity">
    <div class="card-header">
        <h5>{{ $title }}</h5>
        <div class="card-header-right">
            <div class="btn-group card-option">
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    <i class="feather icon-more-horizontal"></i>
                </button>
                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                    <li class="dropdown-item full-card">
                        <a href="#">
                            <span><i class="feather icon-maximize"></i> 全屏</span>
                            <span style="display:none"><i class="feather icon-minimize"></i> 还原</span>
                        </a>
                    </li>
                    <li class="dropdown-item minimize-card">
                        <a href="#">
                            <span><i class="feather icon-minus"></i> 折叠</span>
                            <span style="display:none"><i class="feather icon-plus"></i> 展开</span>
                        </a>
                    </li>
                    <li class="dropdown-item reload-card">
                        <a href="#"><i class="feather icon-refresh-cw"></i> 刷新</a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
    <div class="card-block pb-0">
        <div class="table-responsive">
            <table class="table text-center" id="fixed-columns-left-table">
                <thead>
                <tr>
                    @foreach($items as $item)
                        <th>{{$item}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                {{ $slot }}
                </tbody>
            </table>

        </div>

        <div class="row">
            <div class="col-sm-12 col-md-5">
            </div>
            <div class="col-sm-12 col-md-7">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end" role="navigation">
                        @if ($results->hasPages())
                            {{-- Previous Page Link --}}
                            @if ($results->onFirstPage())
                                <li class="page-item disabled" aria-disabled="true"
                                    aria-label="@lang('pagination.previous')">
                                    <a class="page-link" aria-hidden="true">&lsaquo;</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $results->previousPageUrl() }}" rel="prev"
                                       aria-label="@lang('pagination.previous')">&lsaquo;</a>
                                </li>
                            @endif

                            @for ($i = 1; $i <= $results->lastPage(); $i++)
                                @if ($i == $results->currentPage())
                                    <li class="page-item active" aria-current="page">
                                        <a class="page-link" href="{{'?page='.$i}}">{{$i}}</a>
                                    </li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{'?page='.$i}}">{{$i}}</a></li>
                                @endif

                            @endfor


                            {{-- Next Page Link --}}
                            @if ($results->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $results->nextPageUrl() }}" rel="next"
                                       aria-label="@lang('pagination.next')">&rsaquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled" aria-disabled="true"
                                    aria-label="@lang('pagination.next')">
                                    <a class="page-link" aria-hidden="true">&rsaquo;</a>
                                </li>
                            @endif
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

@if(in_array('action',array_keys($items)))
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">确认删除</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>确认删除 <span class="text-c-red" id="deleteModalBody"></span> 吗?</h6>
                    @if(isset($confrimMessage))
                        <span class="text-c-red">{{ $confrimMessage }}</span>
                    @endif
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" data-dismiss="modal">取消</button>
                    <button href="{{ URL::current() }}"
                            onclick="event.preventDefault();document.getElementById('delete-id-form').submit();"
                            type="button"
                            class="btn btn-danger">删除
                    </button>

                    <form id="delete-id-form" action="{{ route('admin.'.$target.'.delete') }}" method="POST"
                          style="display: none;">
                        @csrf
                        <input type="text" name="id" class="hidden" id="deleteModalId">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

@if(isset($otherModal))
    {{ $otherModal }}
@endif

{{--@section('component-styles')--}}
{{--    <link href="{{ asset('plugins/data-tables/css/datatables.min.css') }}" rel="stylesheet">--}}
{{--@endsection--}}
{{--@section('component-script')--}}
{{--    <script src="{{ asset('plugins/data-tables/js/datatables.min.js') }}"></script>--}}
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            $('#fixed-columns-left-table').DataTable({--}}
{{--                scrollX: true,--}}
{{--                scrollCollapse: true,--}}
{{--                paging: false,--}}
{{--                fixedColumns: {--}}
{{--                    leftColumns: 0,--}}
{{--                    rightColumns: 1--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
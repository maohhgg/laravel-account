@extends('layouts.app')
@section('content')
    <div class="card">

        <div class="card-block">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <form action="{{ route('recharge.submit') }}" method="post">
                    @csrf

                    {{  Form::hidden('url',URL::previous())  }}

                    <div class="form-group mb-4">
                        <label class="form-label">充值用户</label>
                        {{  Form::hidden('id', auth()->user()->id)  }}
                        {{  Form::text(null, auth()->user()->name, array('class'=>'form-control','disabled')) }}
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">金额</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend" id="recharge-data-select">
                                <button class="btn btn-secondary recharge-btn" data-content="100" type="button">
                                    100元
                                </button>
                                <button class="btn btn-secondary recharge-btn" data-content="500" type="button">
                                    500元
                                </button>
                                <button class="btn btn-secondary recharge-btn" data-content="2000" type="button">
                                    2000元
                                </button>
                            </div>
                            {{  Form::text(null, null, ['class'=>'form-control','placeholder'=>'其他','id'=>'recharge-input']) }}
                        </div>
                    </div>


                    <div class="form-group mb-4">
                        <label class="form-label">应付金额</label>
                        {{  Form::hidden('pay_number', null, ['id'=>'recharge-data'])  }}
                        <h2 class="f-w-300 text-c-red" id="recharge-show-data">0</h2>
                    </div>

                    <button type="submit" class="btn btn-primary shadow-2 text-uppercase btn-block @error('pay_number') border-danger @enderror "
                            style="max-width:150px;margin:0 auto;"
                            @error('pay_number') data-toggle="tooltip" data-placement="top"
                            title="{{ $message }}" @enderror>充值</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function updateNumber(num){
            let muted = '<span class=" m-r-3 f-14 text-muted">元</span>';
            $('#recharge-data').val(num);
            $('#recharge-show-data').html(num + muted);
        }
        $('document').ready(function () {
            $('#recharge-data-select .recharge-btn').click(function () {
                $('#recharge-data-select .recharge-btn').removeClass('btn-primary');
                $('#recharge-data-select .recharge-btn').addClass('btn-secondary');
                $(this).addClass('btn-primary');
                updateNumber(this.getAttribute('data-content'))
            });

            $('#recharge-input').keyup(function () {
                updateNumber($(this).val());
            })
        })
    </script>
@endsection



@extends('layouts.app')
@section('styles')
    <link href="{{ asset('fonts/fontawesome/css/fontawesome-all.min.css')  }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row">
                <div class="col-12">
                    <div class="card theme-bg bitcoin-wallet">
                        <div class="card-block" >
                            <h5 class="text-white mb-2">余额</h5>
                            <h2 class="text-white mb-2 f-w-300">{{ sprintf('%0.2f', auth()->user()->balance) }}</h2>
                            <i class="fas fa-yen-sign f-70 text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    @if(!$results->isEmpty())
                        <div class="card">
                            <div class="card-header">
                                <h4>历史</h4>
                            </div>
                            <div class="card-block no-padding">
                                <canvas id="chart-area-1" style="width: 100%; height: 300px"></canvas>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>在线充值</h4>
                        </div>
                        <div class="card-block">
                            <div align="center">
                                <image src="/images/qrcode.jpg"></image>
                            </div>
                        </div>
                    </div>

                </div>

        </div>
    </div>
@endsection

@section('script')

    <script src=" {{ asset('plugins/chart-chartjs/js/Chart.min.js') }}"></script>
    <script>
        let results = {!! json_encode($results->toArray()) !!} ;
        let bar = document.getElementById("chart-area-1").getContext('2d');
        let theme = bar.createLinearGradient(0, 0, 500, 0);
        theme.addColorStop(0, 'rgba(29, 233, 182, 0.6)');
        theme.addColorStop(1, 'rgba(29, 196, 233, 0.6)');
        let data = {
            labels: results.map(function (v, i) {
                return v['created_at'];
            }),
            datasets: [{
                data: results.map(function (v, i) {
                    return v['history'];
                }),
                fill: true,
                borderWidth: 3,
                borderColor: theme,
                backgroundColor: theme,
            }]
        };
        let myBarChart = new Chart(bar, {
            type: 'line',
            data: data,
            responsive: true,
            options: {
                barValueSpacing: 20,
                maintainAspectRatio: false,
                legend: {display: false},
                elements: {
                    point: {radius: 0}
                },
                scales: {
                    xAxes: [{
                        gridLines: {display: false, drawBorder: false},
                        ticks: {display: false}
                    }],
                    yAxes: [{
                        gridLines: {display: false, drawBorder: false},
                        ticks: {display: false}
                    }]
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                    displayColors: false,
                    callbacks: {
                        title: function (tooltipItems, data) {
                            return '';
                        }
                    }
                }
            }
        });
    </script>
@endsection

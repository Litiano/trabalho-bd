@extends("layouts.app")

@section('content')
    <div class="row">
        <div class="col-md-6">
            <canvas id="chart"></canvas>
        </div>
    </div>
@endsection

@section('before-body')
    <script type="text/babel">
        let myLineChart = new Chart($("#chart"), {
            type: 'bar',
            data: @json($data),
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            callback: function (value, index, values) {
                                console.log(values);
                                return 'R$ ' + value.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                            }
                        }
                    }]
                }
            }
        });
    </script>
@endsection
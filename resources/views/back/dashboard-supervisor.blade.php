@extends('back.layouts-supervisor.base')

@section('style')
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.min.css') }}">
<link rel="stylesheet" href="{{ asset('global/assets/examples/css/charts/flot.css')}}">

@stop

@section('body')

<div class="page">
    <div class="page-content container-fluid">
        <div class="row" data-plugin="matchHeight" data-by-row="true">
            <div class="col-xs-12 col-xxl-4 col-lg-12">
                <div class="row h-full">
                    <div class="col-xxl-12 col-lg-6 col-xs-12" style="height:50%;">
                        <!-- Widget Sale Bar -->
                        <a href="{{ route('produksi.jadwal2') }}">
                            <div class="card card-block p-30 bg-blue-600">
                                <div class="card-watermark darker font-size-60 m-15"><i class="icon wb-clipboard"
                                        aria-hidden="true"></i></div>
                                <div class="counter counter-md counter-inverse text-xs-left">
                                    <div class="counter-number-group">
                                        <span
                                    class="counter-number">{{$produksicount}}</span>
                                        <span class="counter-number-related text-capitalize">Jadwal Produksi</span>
                                    </div>
                                    <div class="counter-label text-capitalize">Belum terinput</div>
                                </div>
                            </div>
                        </a>
                        <!-- End Widget Sale Bar -->

                    </div>
                    <div class="col-lg-6 col-xs-12">
                        <div class="card card-block p-25">
                            <!-- Example Realtime -->
                                <h4 class="example-title">Produksi</h4>
                                <div class="example example-responsive">
                                    <canvas id="myAreaChart" width="100%" height="50"></canvas>
                                </div>
                            <!-- End Example Realtime -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop
@section('script')
<script src="{{ asset('global/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('global/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
<script src="{{ asset('global/vendor/chart-js/Chart.min.js')}}"></script>
<script src="{{ asset('js/moment.js')}}"></script>
<script type="text/javascript">
    $(document).ready(
  function() {
      var month_number;

var charts = {
    init: function () {
        // -- Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#292b2c';
        this.ajaxGetPostMonthlyData();

    },

    ajaxGetPostMonthlyData: function () {
        // var urlPath =  'http://' + window.location.hostname + '/get-post-chart-data';
        var urlPath =  '{{ route("get-chart") }}';

        var request = $.ajax( {
            method: 'GET',
            url: urlPath
    } );

        request.done( function ( response ) {
            month_number = response.months_number;
            console.log( response );
            charts.createCompletedJobsChart( response );
        });
    },

    /**
     * Created the Completed Jobs Chart
     */
    createCompletedJobsChart: function ( response ) {

        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    moment('01').format('MMM'),moment('02').format('MMM'),moment('03').format('MMM'),
                    moment('04').format('MMM'),moment('05').format('MMM'),moment('06').format('MMM'),
                    moment('07').format('MMM'),moment('08').format('MMM'),moment('09').format('MMM'),
                    moment('10').format('MMM'),moment('11').format('MMM'),moment('12').format('MMM')], // The response got from the ajax request containing all month names in the database
                datasets: [{
                    label: "Jumlah Produksi",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 20,
                    pointBorderWidth: 2,
                    data: [
                        response[0].jan,
                        response[0].feb,
                        response[0].mar,
                        response[0].apr,
                        response[0].mei,
                        response[0].jun,
                        response[0].jul,
                        response[0].aug,
                        response[0].sep,
                        response[0].oct,
                        response[0].oct,
                    ] // The response got from the ajax request containing data for the completed jobs in the corresponding months
                }],
            },
            options: {
                scales: {
        xAxes: [{
            barPercentage: 0.5,
            barThickness: 20,
            maxBarThickness: 8,
            minBarLength: 2,
            ticks: {
                min: 0,
                max:1000,
                stepSize: 10
            },
            gridLines: {
                offsetGridLines: true
            },
        }],
        yAxes: [{
            display: true,
            ticks: {
                suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                // OR //
                beginAtZero: true,// minimum value will be 0.
                max: 30
            }
        }]
    },
                legend: {
                    display: false
                }
            }
        });
        ctx.onclick = function(evt) {
        var activePoints = myLineChart.getElementsAtEvent(evt);
        if (activePoints[0]) {
            var chartData = activePoints[0]['_chart'].config.data;
            var idx = activePoints[0]['_index'];

            var label = chartData.labels[idx];
            var value = chartData.datasets[0].data[idx];

            var url = "http://example.com/?label=" + label + "&value=" + value;

            localStorage.removeItem('bulan');
            localStorage.setItem('bulan', moment().month(label).format("MM"));
            window.location.replace('{{ route("detail-chart") }}');
            }
        }

    },
    }


charts.init();


} );
</script>
<script type="text/javascript">
</script>
@if($errors->any())
<script>
    toastr["error"]("@foreach($errors->all() as $x) {{ $x }} <br> @endforeach", "Error");
</script>
@endif
@if(session('message'))
<script>
    toastr["info"]("{{ session('message') }}", "Berhasil!");
</script>
@endif
@stop
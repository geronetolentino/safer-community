@extends('layouts.app')

@section('content')

<div class="row layout-spacing">
    <div class="col-xl-3 col-lg-6 col-md-4 col-sm-12 layout-top-spacing">
        @include('establishment.branch.single.profile-nav')
    </div>
    <div class="col-xl-9 col-lg-6 col-md-8 col-sm-12 layout-top-spacing sales">

        <div class="widget-content-area widget-chart-one">
            <div class="widget-content">
                <div class="tabs tab-content">
                    <div id="content_1" class="tabcontent"> 
                        <div id="visitChart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area br-6 mt-3">
            <div class="widget-header">
                <h4>High Risk Visitor</h4>
            </div>
            <div class="table-responsive">
                <table class="datatable table table-hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/widgets/modules-widgets.css') }}" rel="stylesheet" type="text/css">  
@endpush

@push('scripts')
<script src="{{ asset('plugins/apex/apexcharts.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        setTimeout(function(){ 
            $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('es.branch.single.poiList', ['est_code' => $branch->est_code]) }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'status', name: 'status' },
                ],
                order: [[0, 'asc']],
                ordering: false,
                searching: false,
                info: false,
                bLengthChange: false,
                pageLength: 10 
            });
        }, 1000);
    });
</script>
<script type="text/javascript">
try {
    var options1 = {
        chart: {
            fontFamily: "Nunito, sans-serif",
            height: 500,
            type: "area",
            zoom: {
                enabled: false,
            },
            dropShadow: {
                enabled: true,
                opacity: 0.3,
                blur: 5,
                left: -7,
                top: 22,
            },
            toolbar: {
                show: false,
            },
        },
        colors: ["#1b55e2", "#e7515a"],
        dataLabels: {
            enabled: false,
        },
        markers: {
            discrete: [
                {
                    seriesIndex: 0,
                    dataPointIndex: 7,
                    fillColor: "#000",
                    strokeColor: "#000",
                    size: 5,
                },
                {
                    seriesIndex: 2,
                    dataPointIndex: 11,
                    fillColor: "#000",
                    strokeColor: "#000",
                    size: 4,
                },
            ],
        },
        subtitle: {
            text: "Using QR code scanner",
            align: "left",
            margin: 0,
            offsetX: -10,
            offsetY: 35,
            floating: false,
            style: {
                fontSize: "14px",
                color: "#888ea8",
            },
        },
        title: {
            text: "Total Visitors",
            align: "left",
            margin: 0,
            offsetX: -10,
            offsetY: 0,
            floating: false,
            style: {
                fontSize: "25px",
                color: "#0e1726",
            },
        },
        stroke: {
            show: true,
            curve: "smooth",
            width: 2,
            lineCap: "square",
        },
        series: [
            {
                name: "Visitors",
                data: @json($logs->pluck('count')),
            },
        ],
        labels: @json($logs->pluck('month')),
        xaxis: {
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            crosshairs: {
                show: true,
            },
            labels: {
                offsetX: 0,
                offsetY: 5,
                style: {
                    fontSize: "12px",
                    fontFamily: "Nunito, sans-serif",
                    cssClass: "apexcharts-xaxis-title",
                },
            },
        },
        yaxis: {
            labels: {
                formatter: function (value, index) {
                    return value;
                },
                offsetX: -22,
                offsetY: 0,
                style: {
                    fontSize: "12px",
                    fontFamily: "Nunito, sans-serif",
                    cssClass: "apexcharts-yaxis-title",
                },
            },
        },
        grid: {
            borderColor: "#e0e6ed",
            strokeDashArray: 5,
            xaxis: {
                lines: {
                    show: true,
                },
            },
            yaxis: {
                lines: {
                    show: false,
                },
            },
            padding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: -10,
            },
        },
        legend: {
            position: "top",
            horizontalAlign: "right",
            offsetY: -50,
            fontSize: "16px",
            fontFamily: "Nunito, sans-serif",
            markers: {
                width: 10,
                height: 10,
                strokeWidth: 0,
                strokeColor: "#fff",
                fillColors: undefined,
                radius: 12,
                onClick: undefined,
                offsetX: 0,
                offsetY: 0,
            },
            itemMargin: {
                horizontal: 0,
                vertical: 20,
            },
        },
        tooltip: {
            theme: "dark",
            marker: {
                show: true,
            },
            x: {
                show: false,
            },
        },
        fill: {
            type: "gradient",
            gradient: {
                type: "vertical",
                shadeIntensity: 1,
                inverseColors: !1,
                opacityFrom: 0.28,
                opacityTo: 0.05,
                stops: [45, 100],
            },
        },
        responsive: [
            {
                breakpoint: 575,
                options: {
                    legend: {
                        offsetY: -30,
                    },
                },
            },
        ],
    };

    var chart1 = new ApexCharts(document.querySelector("#visitChart"), options1);

    chart1.render();
} catch (e) {
    console.log(e);
}
</script>
@endpush
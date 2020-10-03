@extends('layouts.app')

@section('content')

<div class="row layout-top-spacing">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-spacing">
        <div class="widget widget-one_hybrid widget-referral">
            <div class="widget-heading">
                <p class="w-value">
                    Total Covid-19 Positive 
                    <span class="float-right">{{ $positive_overall }}</span>
                </p>
            </div>
        </div>
        <div class="widget-content widget-content-area br-6 mt-3">
            <div class="table-responsive">
                <table class="datatable table table-hover positive-list" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-spacing">
        <div class="widget widget-one_hybrid widget-followers">
            <div class="widget-heading">
                <p class="w-value">
                    Total PUI
                    <span class="float-right">{{ $pui_overall }}</span>
                </p>
            </div>
        </div>
        <div class="widget-content widget-content-area br-6 mt-3">
            <div class="table-responsive">
                <table class="datatable table table-hover pui-list" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-spacing">
        <div class="widget widget-one_hybrid widget-engagement">
            <div class="widget-heading">
                <p class="w-value">
                    Total PUM
                    <span class="float-right">{{ $pum_overall }}</span>
                </p>
            </div>
        </div>
        <div class="widget-content widget-content-area br-6 mt-3">
            <div class="table-responsive">
                <table class="datatable table table-hover pum-list" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row sales layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                {{-- <h5 class="">Visits</h5> --}}
                {{-- <ul class="tabs tab-pills">
                    <li><a href="javascript:void(0);" id="tb_1" class="tabmenu">Monthly</a></li>
                </ul> --}}
            </div>

            <div class="widget-content">
                <div class="tabs tab-content">
                    <div id="content_1" class="tabcontent">
                        <div id="revenueMonthly"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/widgets/modules-widgets.css') }}" rel="stylesheet" type="text/css">  
<link href="{{ asset('css/components/cards/card.css') }}" rel="stylesheet" type="text/css">
<link  href="{{ asset('css/widgets/modules-widgets.css') }}" rel="stylesheet" type="text/css">  
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
            $('.positive-list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('ma.home.positiveList') }}',
                columns: [
                    { data: 'id', name: 'id' },
                ],
                order: [[0, 'asc']],
                searching: false,
                info: false,
                bLengthChange: false,
                pageLength: 10 
            });
        }, 1000);
        setTimeout(function(){ 
            $('.pui-list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('ma.home.puiList') }}',
                columns: [
                    { data: 'id', name: 'id' },
                ],
                order: [[0, 'asc']],
                searching: false,
                info: false,
                bLengthChange: false,
                pageLength: 10 
            });
        }, 2000);
        setTimeout(function(){ 
            $('.pum-list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('ma.home.pumList') }}',
                columns: [
                    { data: 'id', name: 'id' },
                ],
                order: [[0, 'asc']],
                searching: false,
                info: false,
                bLengthChange: false,
                pageLength: 10 
            });
        }, 3000);
    });
</script>
<script type="text/javascript">
var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nove", "Dec"];
var posivite = {!! $positive_monthly !!};
var pui = {!! $pui_monthly !!};
var pum = {!! $pum_monthly !!};

var chartPositive = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
var chartPui = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
var chartPum = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

for (var j = 0; j < posivite.length; j++) {
    chartPositive[posivite[j]['month']-1] = posivite[j]['count'];
}

for (var j = 0; j < pui.length; j++) {
    chartPui[pui[j]['month']-1] = pui[j]['count'];
}

for (var j = 0; j < pum.length; j++) {
    chartPum[pum[j]['month']-1] = pum[j]['count'];
}

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
        colors: ["#e7515a", "#e2a03f", "#8dbf42"],
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
            text: "Within the system data.",
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
            text: "Statistics",
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
                name: "Covid-19 Positive",
                data: chartPositive,
            },
            {
                name: "PUI",
                data: chartPui,
            },
            {
                name: "PUM",
                data: chartPum,
            },
        ],
        labels: months,
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

    var chart1 = new ApexCharts(document.querySelector("#revenueMonthly"), options1);

    chart1.render();
} catch (e) {
    // statements
    console.log(e);
}
</script>
@endpush
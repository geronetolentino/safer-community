@extends('layouts.app')

@section('content')
<div class="row sales layout-top-spacing">

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h5 class="">{{ $qry['municipality'] }} Visitor Graph</h5>
                <ul class="tabs tab-pills">
                    <li><a href="javascript:void(0);" id="tb_1" class="tabmenu">Monthly</a></li>
                </ul>
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
@endpush

@push('scripts')
<script src="{{ asset('plugins/apex/apexcharts.min.js') }}"></script>
<script src="{{ asset('js/widgets/modules-widgets.js') }}"></script>
@endpush
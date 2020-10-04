@extends('layouts.app')

@section('content')

<div class="alert alert-dark mb-4" role="alert">
    <h4 class="text-light mb-0">Welcome to {{ env('APP_NAME') }}</h4> 
</div> 

<div class="row layout-top-spacing">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-spacing">
        <div class="widget widget-one_hybrid widget-referral">
            <div class="widget-heading">
                <p class="w-value">
                    Total Covid-19 Positive 
                    <span class="float-right">0</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-spacing">
        <div class="widget widget-one_hybrid widget-followers">
            <div class="widget-heading">
                <p class="w-value">
                    Total PUI
                    <span class="float-right">0</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-spacing">
        <div class="widget widget-one_hybrid widget-engagement">
            <div class="widget-heading">
                <p class="w-value">
                    Total PUM
                    <span class="float-right">0</span>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row sales layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-chart-one">
            <div class="widget-content">
               
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

</script>
@endpush
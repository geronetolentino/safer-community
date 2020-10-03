@extends('layouts.app')

@section('content')

<div class="row layout-top-spacing">

    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-spacing">
        <div class="widget widget-one_hybrid widget-followers">
            <div class="widget-heading">
                <p class="w-value">
                    Total Branches
                    <span class="float-right">{{ $branches->count() }}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-spacing">
        <div class="widget widget-one_hybrid widget-followers">
            <div class="widget-heading">
                <p class="w-value">
                    Total Employees
                    <span class="float-right">{{ $employees->count() }}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-spacing">
        <div class="widget widget-one_hybrid widget-followers">
            <div class="widget-heading">
                <p class="w-value">
                    Total Visits
                    <span class="float-right">{{ $visits->count() }}</span>
                </p>
            </div>
        </div>
    </div>
</div>

{{-- <div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-content widget-content-area">
            
            
        </div>
    </div>
</div> --}}

@endsection
@push('styles')

<link href="{{ asset('css/widgets/modules-widgets.css') }}" rel="stylesheet" type="text/css">

@endpush
@push('scripts')


@endpush
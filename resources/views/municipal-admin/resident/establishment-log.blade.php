@extends('layouts.app')

@section('content')

<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
			<div class="mt-container mx-auto">

                <div class="alert alert-icon-left alert-light-warning mb-4" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12" y2="17"></line>
                    </svg>
                    <strong>Warning!</strong> 
                    Your every visit/view in this page is being logged.<br>

                    <strong class="text-danger">You viewed this information {{ $accessLogs->count() }} time(s).</strong>
                </div>

                <h3>POI #: {{ $info->poi_id }}</h3>
                <hr>
				<div class="timeline-line">
                    @forelse($logs as $log) 
                    <div class="item-timeline">
                        <p class="t-time">{{ $log->created_at->format('M d Y')}}</p>
                        <div class="t-dot t-dot-dark"></div>
                        <div class="t-text">
                            @php 
                            $in = Carbon\Carbon::parse($log->checkin)->format('g:i A');
                            if ($log->status == 'OUT') {
                                $out = Carbon\Carbon::parse($log->checkout)->format('g:i A');
                            } else {
                                $out = null;
                            }
                            @endphp
                            <p>{{ $log->establishment->name }} <br>
                                <small>{{ $in . ' - ' . $out}}</small>
                            </p>
                            <p class="t-meta-time">{{ $log->establishment->address }}</p>
                        </div>
                    </div>
                    @empty
                    <h4 class="text-primary">No travel history found.</h4>
                    @endforelse
                </div>
			</div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style type="text/css">
    .timeline-line .item-timeline .t-time {
        min-width: 140px !important;
    }
    .timeline-line .item-timeline .t-text .t-meta-time {
        min-width: 200px;
    }
    .user-profile .widget-content-area .user-info-list ul.contacts-block {
        max-width: 350px;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/components/notification/custom-snackbar.js') }}"></script>
<script>
    $(document).ready(function() {
    	

    });
</script>
@endpush
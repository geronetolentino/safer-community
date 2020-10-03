@extends('layouts.app')

@section('content')

<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
			<div class="mt-container mx-auto">

                <h3 class="">Information Access Logs</h3>
				<div class="timeline-line">
                    @forelse($logs as $log) 
                    <div class="item-timeline">
                        <p class="t-time">{{ $log->created_at->format('M d, Y') }}</p>
                        <div class="t-dot t-dot-dark"></div>
                        <div class="t-text">
                            @php 
                            
                            @endphp
                            <p>{{ $log->accessedBy->name }} <br>
                                <small>{{ $log->accessedBy->uType->code }}</small>
                            </p>
                            <p class="t-meta-time">{{ $log->created_at->format('g:i A') }}</p>
                        </div>
                    </div>
                    @empty
                    <h4 class="text-primary">No information access found.</h4>
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
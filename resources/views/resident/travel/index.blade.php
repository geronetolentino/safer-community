@extends('layouts.app')

@section('content')

<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
			<div class="mt-container mx-auto">

                <h3 class="">Travel History</h3>
				<div class="timeline-line">
                    @forelse($est_logs as $log) 
                    <div class="item-timeline">
                        <p class="t-time">{{ $log->created_at->format('M d, Y') }}</p>
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
                            <p class="t-meta-time">{{ $log->establishment->account->fullAddress }}</p>
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
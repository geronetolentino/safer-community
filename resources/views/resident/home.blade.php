@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6 mb-4">
        	<div class="text-center">
        		<h4>Welcome to</h4>
        		<h2>I am Safe</h2>
        	</div>
        </div>

        @if(Auth::user()->employeer && Auth::user()->employeer->scannerAccess->count() > 0)
        <div class="widget-content widget-content-area br-6">
        	<div class="text-center">
        		<h4>Scanner Access</h4>
        	</div>

        	<ul class="list-group task-list-group">
				@foreach(Auth::user()->employeer->scannerAccess as $key => $access)
				
				<li class="list-group-item list-group-item-action" id="x_{{ $key }}">
					<div class="media">
						<div class="media-body">
							<span class="tx-inverse">
								{{ $access->scanner->name }} <span class="mg-b-0 badge outline-badge-{{ $access->scanner->scannerStatus['color'] }}">{{ $access->scanner->scannerStatus['text'] }}</span>
							</span>
						</div>
						<div class="mr-6">
							@if ($access->scanner->scannerStatus['text'] == 'Online')
							<a href="{{ route('rs.scanner', ['uid'=>$access->scanner->uid]) }}" class="btn btn-primary btn-sm">Use</a>
							@else
							<button class="btn btn-dark btn-sm disabled">Use</button>
							@endif
						</div>
					</div>
				</li>
				@endforeach
			</ul>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')


@endpush

@push('scripts')


@endpush
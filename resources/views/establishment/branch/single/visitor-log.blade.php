@extends('layouts.app')

@section('content')

<div class="row layout-spacing">
    <div class="col-xl-3 col-lg-6 col-md-4 col-sm-12 layout-top-spacing">
        @include('establishment.branch.single.profile-nav')
    </div>
    <div class="col-xl-9 col-lg-6 col-md-8 col-sm-12 layout-top-spacing">
        <div class="widget-content-area">
            <div class="widget-content">
				<div class="table-responsive">
				    <table class="datatable table table-hover" style="width: 100%;">
				        <thead>
				            <tr>
				                <th>#</th>
				                <th>Visitor</th>
				                <th>Date</th>
				                <th>Entry Status</th>
				                <th class="no-content">Action</th>
				            </tr>
				        </thead>
				        <tbody></tbody>
				        <tfoot>
				            <tr>
				                <th>ID</th>
				                <th>Visitor</th>
				                <th>Date</th>
				                <th>Entry Status</th>
				                <th>Action</th>
				            </tr>
				        </tfoot>
				    </table>
				</div>
			</div>
		</div>
    </div>
</div>

@endsection

@push('styles')
<link href="{{ asset('css/widgets/modules-widgets.css') }}" rel="stylesheet" type="text/css">  
<link href="{{ asset('css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script type="text/javascript">

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.datatable').DataTable({
            "order": [[ 2, "asc" ]],
            processing: true,
            serverSide: true,
            ajax: '{{ route('es.branch.single.visitor.log.list',['est_code'=>$branch->est_code]) }}',
            columns: [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'visitor', name: 'visitor' }, 
                { data: 'date', name: 'date' }, 
                { data: 'status', name: 'status' }, 
                { data: 'action', name: 'action' }, 
            ]
        });
    });
</script>
@endpush
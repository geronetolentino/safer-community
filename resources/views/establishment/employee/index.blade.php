@extends('layouts.app')

@section('content')

<div class="row layout-top-spacing">
    <div class="col-md-4">
        <h5 onclick="copyText()" class="btn btn-primary">
        	Copy employee enrollment page
        </h5>
        <input type="hidden" id="eep" value="{{ route('employee.enroll', ['eep'=>Auth::user()->establishment->est_code]) }}">
    </div>
    <div class="col-md-8"></div>
</div>

@if($pendingEmployees->count() > 0)
<div class="row layout-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="widget-content widget-content-area">
            <h4>Employee Enroll Request</h4>
            <ul class="list-group list-group-media">
                @foreach($pendingEmployees as $pending)
                <li class="list-group-item list-group-item-action" id="x_{{ $pending->id }}">
                    <div class="media">
                        <div class="mr-3">
                            <img alt="avatar" src="{{ route('image.process',['filename'=>$pending->resident->info->profile_photo]) }}" class="img-fluid rounded-circle">
                        </div>
                        <div class="media-body">
                            <h6 class="tx-inverse">{{ $pending->resident->name }}</h6>
                            <p class="mg-b-0">{{ $pending->resident->fullAddress }}</p>
                        </div>
                        <div class="mr-6">
                            <button class="btn btn-primary btn-rounded btn-status" data-eeid="{{ $pending->id }}" data-status="1">
                                <i data-feather="check-circle"></i>
                                Approve
                            </button>
                            <button class="btn btn-dark btn-rounded btn-status" data-eeid="{{ $pending->id }}" data-status="0">
                                <i data-feather="x-circle"></i>
                                Decline
                            </button>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<div class="row layout-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
			<div class="table-responsive">
				<table class="datatable table table-hover" style="width: 100%;">
					<thead>
				    	<tr>
				    		<th>#</th>
				    		<th>Employee</th>
				    		<th>Address</th>
				    		<th>Health Status</th>
				    		<th class="no-content">Action</th>
				    	</tr>
				    </thead>
					<tbody></tbody>
					<tfoot>
						<tr>
				    		<th>ID</th>
				    		<th>Employee</th>
				    		<th>Address</th>
				    		<th>Health Status</th>
				    		<th>Action</th>
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
<link href="{{ asset('css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/components/tabs-accordian/custom-tabs.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/components/custom-list-group.css') }}" rel="stylesheet" type="text/css" />
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

		$('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('es.employee.list') }}',
            columns: [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'employee', name: 'employee' }, 
                { data: 'address', name: 'address' }, 
                { data: 'health_status', name: 'health_status' }, 
                { data: 'action', name: 'action' }, 
            ]
        });
        $('body').on('click', '.btn-status', function() {
        	var eeid = $(this).data('eeid'),
        		status = $(this).data('status');

        	if (status == 0) {
        		var text = 'Are you sure you want to decline resident employee request.';
        		var btnText = 'Decline';
        	} else {
        		var text = 'Are you sure you want to approve resident as employee.';
        		var btnText = 'Approve';
        	}

       		Swal.fire({
                title: "Confirm",
                text: text,
                icon: "question",
                reverseButtons: true,
                showCancelButton: true,
                confirmButtonText: btnText,
                cancelButtonText: "Cancel",
                buttonsStyling: true
            }).then((result) => {  
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('es.employee.status') }}",
                        data: { 
                            eeid: eeid,
                            status: status
                        },
                        dataType: 'json',
                        success: function(response) {

                            $('#x_'+eeid).remove();

                            Swal.fire({
                                title: "Employee Enrollment",
                                text: response.message,
                                icon: response.status
                            });

                            var dTable = $('.datatable').dataTable();
                            dTable.fnDraw(false);
                        },
                        failure: function (response) {
                            Swal.fire({
                                title: "Internal Error",
                                text: "Oops, something went wrong.", 
                                icon: "error"
                            })
                        }
                    });
                }
            });
        });
    });

    function copyText(element) {
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($('input#eep').val()).select();
		document.execCommand("copy");
		$temp.remove();

		Swal.fire({
			text: 'Copied: Employee enrollment page',
		});
    }
</script>
@endpush
@extends('layouts.app')
@section('content')
<div class="alert alert-dark mb-4" role="alert">
	<h4 class="text-light mb-0">Welcome to {{ env('APP_NAME') }}</h4> 
</div> 

<div class="row">
    <div class="col-xl-3 col-lg-3 col-sm-3 layout-spacing">
    	<div class="row">
    		<div class="col-md-12">
	    		@include('user-resident.profile')
    		</div>
    		<div class="col-md-12">
	    		@include('user-resident.hci')
    		</div>
    	</div>
	      
    </div>
    <div class="col-xl-5 col-lg-5 col-sm-5 layout-spacing">
        @include('user-resident.checklist')
    </div>
    <div class="col-xl-4 col-lg-4 col-sm-4 layout-spacing">
    	@include('user-resident.checklist-history')
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/elements/alert.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/components/custom-list-group.css') }}" rel="stylesheet" type="text/css">

<style type="text/css">
.widget-table-two .table tr > td:nth-last-child(2) .td-content {
    text-align: unset !important;
}
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

		$('body').on('click', '.set_hci', function() {
        	var action = $(this).data('action'),
        		hci_id = $('.hci_id').find(":selected").val(),
                text = action=='set'?'Selected health care institution can see your daily health checklist for evaluation.':'Do you want to send a request for discharge. Your current date validator wont see your new daily health checklist.';

            Swal.fire({
                title: "Health Data Validator",
                text: text,
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                buttonsStyling: true
            }).then((result) => {  
                if (result.isConfirmed) {
                	$.ajax({
		                type: 'POST',
						url: '{{ route('rs.hci.update') }}',
						data: {
							hci_id: hci_id,
							action: action
						},
		                dataType: 'json',
		                success: function (data) {
		                        
		                	Swal.fire({
		                		title: data.message, 
		                		icon: data.status,
		                		confirmButtonText: 'Close'
		                	}).then((result) => {  
		                		location.reload();
		                	});
		                },
                        failure: function (response) {
                            Swal.fire({
                                title: "Internal Error",
                                text: "Oops, something went wrong.", 
                                icon: "error"
                            })
                        },
		                error: function (data) {
		                }
		            });
                }
            });
		});

		$(".dhChecklist").change(function() {
			if ($(this).val() == 1000) {
				$(".dhChecklist").prop('checked', false);
				$(".nota").prop('checked', true);
			} else {
				$(".nota").prop('checked', false);

			}
		});

		$('body').on('click', '.submit-checklist', function() {

            Swal.fire({
                title: "Health Checklist",
                text: "Submit daily health checklists.",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                buttonsStyling: true
            }).then((result) => {  
                if (result.isConfirmed) {
                	$.ajax({
		                type: 'POST',
						url: '{{ route('rs.health.check.list.store') }}',
						data: $('.dhChecklist:checked').serialize(),
		                dataType: 'json',
		                success: function (data) {
		                        
		                	Swal.fire({
		                		title: data.message, 
		                		icon: data.status,
		                		confirmButtonText: 'Close'
		                	}).then((result) => {  
		                		location.reload();
		                	});
		                },
                        failure: function (response) {
                            Swal.fire({
                                title: "Internal Error",
                                text: "Oops, something went wrong.", 
                                icon: "error"
                            })
                        },
		                error: function (data) {
		                }
		            });
                }
            });
		});


		

    });
 
</script>

@endpush
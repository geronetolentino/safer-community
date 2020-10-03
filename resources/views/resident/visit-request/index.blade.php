@extends('layouts.app')

@section('content')

<div class="row layout-top-spacing">
    <div class="col-md-4">
        <button class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#registerVisitModal"><i data-feather="plus-circle"></i> Add Visit</button>
    </div>
    <div class="col-md-8">
        
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive mb-4 mt-4">
                <table class="datatable table table-hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Date of Visit</th>
                            <th>Reason of Visit</th>
                            <th>Travel History</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th class="no-content"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th>Date of Visit</th>
                            <th>Reason of Visit</th>
                            <th>Travel History</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal animated fadeInUp custo-fadeInUp" id="registerVisitModal" tabindex="-1" role="dialog" aria-labelledby="registerVisitModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        	<form method="POST" name="register-visit"> 
	            <div class="modal-header" id="registerVisitModal">
	                <h5 class="modal-title">Register a visit</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
	                    <i data-feather="x"></i>
	                </button>
	            </div>
	            <div class="modal-body">
	            	<p class="text-info"><strong>Visit Information</strong></p>
	               	<div class="form-group">
					    <label for="date_ov">Date of Visit (MM/DD/YYYY)</label>
					    <input type="text" class="form-control datepicker" id="date_ov" name="date_ov"{{--  value="<?=date('m/d/Y'); ?>" placeholder="Ex: <?=date('m/d/Y'); ?>" --}}>
					</div> 
	               	<div class="form-group">
					    <label for="reason_ov">Reason of Visit</label>
					    <input type="text" class="form-control" id="reason_ov" name="reason_ov" placeholder="...">
					</div> 
					<br>
	            	<p class="text-info"><strong>Travel History</strong></p>
	               	<div class="form-group">
					    <label for="address">Address</label>
					    <input type="text" class="form-control" id="address" name="address" placeholder="...">
					</div> 
	               	<div class="form-group">
					    <label for="date_visited">Date Visited (MM/DD/YYYY)</label>
					    <input type="text" class="form-control datepicker" id="date_visited" name="date_visited" placeholder="">
					</div> 
	               	<div class="form-group">
					    <label for="length_of_stay">Length of Stay</label>
					    <input type="text" class="form-control" id="length_of_stay" name="length_of_stay" placeholder="...">
					</div> 
	            </div>
	            <div class="modal-footer md-button">
					<button class="btn" data-dismiss="modal">
						<i class="flaticon-cancel-12"></i> 
						Discard
					</button>
	                <button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
        </div>
    </div>
</div>

<div class="modal animated fadeInUp custo-fadeInUp" id="registerTravelModal" tabindex="-1" role="dialog" aria-labelledby="registerTravelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        	<form method="POST" name="register-travel"> 
	            <div class="modal-header" id="registerTravelModalLabel">
	                <h5 class="modal-title">Register a travel</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
	                    <i data-feather="x"></i>
	                </button>
	            </div>
	            <div class="modal-body">
	            	<p class="text-info"><strong>Travel History</strong></p>
	               	<div class="form-group">
	               		<input type="hidden" id="visit_id" name="visit_id" value="">
					    <label for="address">Address</label>
					    <input type="text" class="form-control" id="address" name="address" placeholder="">
					</div> 
	               	<div class="form-group">
					    <label for="date_visited">Date Visited</label>
					    <input type="text" class="form-control datepicker" id="date_visited" name="date_visited" placeholder="">
					</div> 
	               	<div class="form-group">
					    <label for="length_of_stay">Length of Stay</label>
					    <input type="text" class="form-control" id="length_of_stay" name="length_of_stay" placeholder="...">
					</div> 
	            </div>
	            <div class="modal-footer md-button">
					<button class="btn" data-dismiss="modal">
						<i class="flaticon-cancel-12"></i> 
						Discard
					</button>
	                <button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link href="{{ asset('plugins/animate/animate.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('js/components/notification/custom-snackbar.js') }}"></script>
<script>
    $(document).ready(function() {
    	$('.datatable').DataTable();

        // $('.datatable').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: '{{ route('rs.visits') }}',
        //     // columnDefs: [{
        //     //     targets: [0, 1, 2],
        //     //     className: 'mdl-data-table__cell--non-numeric'
        //     // }]
        //      "oLanguage": {
        //         "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
        //         "sInfo": "Showing page _PAGE_ of _PAGES_",
        //         "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        //         "sSearchPlaceholder": "Search...",
        //        "sLengthMenu": "Results :  _MENU_",
        //     },
        // });

        var form = "form[name='register-visit']";
		$(form).validate({
		    rules: {
		        date_ov: "required",
		        reason_ov: "required",
		        address: "required",
		        date_visited: "required",
		        length_of_stay: "required",
		    },
		    messages: {
		        date_ov: "Please provide a preferred date of visit.",
		        reason_ov: "Please provide a reason.",
		        address: "Please provide a address.",
		        date_visited: "Please provide visited date.",
		        length_of_stay: "Please provide length of stay.",
		    },
		    beforeSubmit: function() {

		    	$.blockUI({
			        message: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>',
			        fadeIn: 800, 
			        timeout: 2000, //unblock after 2 seconds
			        overlayCSS: {
			            backgroundColor: '#1b2024',
			            opacity: 0.8,
			            zIndex: 1200,
			            cursor: 'wait'
			        },
			        css: {
			            border: 0,
			            color: '#fff',
			            zIndex: 1201,
			            padding: 0,
			            backgroundColor: 'transparent'
			        }
			    });

		    },
		    submitHandler: function (e) {
		        //form.submit();
		        e.preventDefault();
		        
		  		$.ajax({
				    type: 'POST',
				    url: "",
				    data: $(form).serialize(),
				    dataType: 'json',
				    success: function(data) {
				        

				    },
				    error: function(data) {
				        console.log(data);
				    }
				});

				$.unblockUI();

		        $('#registerVisitModal').modal('hide');
		        
		        Snackbar.show({
		        	text: 'Your visit has been registered.',
			        actionText: 'DISMISS'
			    });


		        $('#registerTravelModal').modal('show');

		    },
		});


        setTimeout(function(){
			//$('.datatable').DataTable().ajax.reload();
    	}, 5000);
    });
</script>
@endpush
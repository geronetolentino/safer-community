<div class="layout-spacing">
    <div class="widget-content widget-content-area">
        <div class="widget-heading">
			<h5>Person of Interest</h5>
		</div>
        <div class="text-center">
            <img src="{{ route('image.process',['filename'=>'default-avatar.png']) }}" width="150px">
            <h4 class="branch-name">{{ $patient->poi_id }}</h4>
            <p class="mb-0">Current Status: 
            	<strong>{{ $patient->resident->user->healthData->current_status??'No record' }}</strong> 
            </p>
            <p class="">Under Quarantine: 
            	<strong>{{ $patient->resident->user->healthData->quarantine_period??'No' }}</strong> 
            </p>
            <button class="btn btn-primary update-current-status"><i data-feather="edit" ></i> Update current Status</button>
        </div>
        <div class="list-group mt-3">
       	</div>
    </div>
</div>

<div class="modal fade" id="current_status" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="modalFormStatus" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">ModalTitle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">

                	<div class="alert alert-icon-left alert-light-warning mb-4" role="alert">
	                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle">
	                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
	                        <line x1="12" y1="9" x2="12" y2="13"></line>
	                        <line x1="12" y1="17" x2="12" y2="17"></line>
	                    </svg>
	                    <strong>Warning!</strong> <br>
	                    <strong class="text-danger">
	                    	This will notify the LGU of poi and all the visited establishments.
	                    </strong><br>
                        <strong class="text-danger">
                            This action can't undo notification and alerts.
                        </strong>
	                </div>

                    <input type="hidden" name="id" id="id" value="{{ $patient->poi_id }}">
                    <div class="form-group">
                        <label for="current_status">Status</label>
                        <select class="form-control" name="current_status" id="current_status">
                            <option value="PUM">PUM</option>
                            <option value="PUI">PUI</option>
                            <option value="Covid-19 Positive">Covid-19 Positive</option>
                            <option value="Covid-19 Negative">Covid-19 Negative</option>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="quarantine_period">Quarantine Period</label>
                        <input type="number" class="form-control form-control-sm" id="quarantine_period" name="quarantine_period" required="" placeholder="Type here..." min="7">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">
                        <i class="flaticon-cancel-12"></i> 
                        Discard
                    </button>
                    <button type="submit" class="btn btn-primary submit">Submit</button>
                </div>

            </form>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('body').on('click', '.update-current-status', function() {
            $('#modalFormStatus').trigger("reset");
            $('#modalTitle').text("Set Health Status");
            $('#current_status').modal({backdrop: 'static', keyboard: false});
        });

    });

    if ($("#modalFormStatus").length > 0) {

        $('#modalFormStatus').validate({
            rules: {
                id: "required",
                status: "required",
            },
            messages: {
                id: "This field is required",
                status: "This field is required",
            },
            errorElement: "div",
            submitHandler: function() {

                $('.submit').attr('disabled', true);
                  
                $.ajax({
                    data: $('#modalFormStatus').serialize(),
                    url: "{{ route('hp.patient.set.health.status') }}",
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {

                        Swal.fire({
                            title: 'Health Status Update',
                            text: data.message,
                            icon: data.status
                        }).then(okay => {
                            if (okay) {
                                $('#modal').modal('toggle');
                                location.reload(); 
                            }
                        });

                        $('.submit').attr('disabled', false);
                        var dTable = $('.datatable').dataTable();
                        dTable.fnDraw(false);
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('.submit').attr('disabled', false);
                    }
                });

            }
        });
    }   
</script>
@endpush

{{-- <div class="layout-spacing">
    <div class="widget-content widget-content-area">
        <div class="widget-heading">
			<h5 class="">HCI History</h5>

			<ul class="list-group list-group-media">
			    <li class="list-group-item list-group-item-action">
			        <div class="media">
			            <div class="mr-3">
			                <img alt="avatar" src="assets/img/profile-1.jpeg" class="img-fluid rounded-circle">
			            </div>
			            <div class="media-body">
			                <h6 class="tx-inverse">Luke Ivory</h6>
			                <p class="mg-b-0">Project Lead</p>
			            </div>
			        </div>
			    </li>
			</ul>
			
		</div>
    </div>
</div> --}}
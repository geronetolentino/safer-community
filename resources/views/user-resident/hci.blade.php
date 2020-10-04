<div class="widget widget-content-area br-6 mb-4">
		    		<div class="widget-heading">
						<h5 class="">Health Care Institution</h5>
					</div>
		    		<div class="widget-content">
		    			<hr>
		    			<label for="" class="">Choose your HCI (Locked)</label>
		    			<select class="custom-select mb-2 hci_id" name="hci_id" id="hci_id">
		    				@foreach($hospitals as $hospital)
						    <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
						    @endforeach
						</select>

						@if (!$patient)
						<button class="btn btn-primary btn-lg btn-rounded set_hci self-admit mb-5" data-action="set">
							<i data-feather="user"></i>
							Self Admit (Virtual Patient)
						</button>
						@else 
						<button class="btn btn-warning btn-lg btn-rounded set_hci dismmiss mb-5" data-action="dismmiss">
							Request for Discharge
						</button>

						@if ($patient->discharge_request)
						<div class="alert alert-danger mb-4" role="alert">
    						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    							<i data-feather="x"></i>
    						</button>
    						Request for discharge is now on process.
							</div> 
						@endif

						@endif
	    			</div>
    			</div>
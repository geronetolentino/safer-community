<div class="widget widget-content-area br-6 mb-4">
			<div class="widget-heading">
				<h5 class="">Daily Health Check List</h5>
			</div>
			<div class="widget-content">

			@if($patient)
				@if($todayCheckList)
				@php 
				$submittedList = $todayCheckList->items;
				@endphp
				<form id="checklistForm">
					@csrf
					<ul class="list-group task-list-group">
						@foreach($checklists as $checklist)
					    <li class="list-group-item list-group-item-action">
					        <div class="n-chk">
					            <label class="new-control new-checkbox checkbox-primary w-100 justify-content-between">
									<input type="checkbox" class="dhChecklist new-control-input {{ $checklist->id==1000?'nota':'' }}" name="checklist[]" value="{{ $checklist->id }}" {{ $submittedList->contains('checklist_id',$checklist->id)?'checked':'' }}>
					              	<span class="new-control-indicator"></span>
					                <span class="ml-2">{{ $checklist->question }}</span>
					            </label>
					        </div>
					    </li>
					    @endforeach
					</ul>
				</form>
				@else 

				<form id="checklistForm">
					@csrf
					<ul class="list-group task-list-group">
						@foreach($checklists as $checklist)
					    <li class="list-group-item list-group-item-action">
					        <div class="n-chk">
					            <label class="new-control new-checkbox checkbox-primary w-100 justify-content-between">
					              	<input type="checkbox" class="dhChecklist new-control-input {{ $checklist->id==1000?'nota':'' }}" name="checklist[]" value="{{ $checklist->id }}">
					              	<span class="new-control-indicator"></span>
					                <span class="ml-2">{{ $checklist->question }}</span>
					              
					            </label>
					        </div>
					    </li>
					    @endforeach
					</ul>
				</form>
				@endif

				<div class="row">
					<div class="col-md-8"></div>
					<div class="col-md-4">
						<button class="btn btn-lg btn-rounded btn-block btn-primary mt-2 submit-checklist">
							<i data-feather="send"></i>
							Submit
						</button>
					</div>
				</div>
			@else 
			<div class="alert alert-arrow-right alert-icon-right alert-light-danger mb-4"
			role="alert">
			    <i data-feather="alert-circle"></i>
			    <strong>No HCI / Data Validator.</strong> <br>
			    Please select health care institutions and do Self Admit first.
			</div>
			@endif
			</div>
		</div>
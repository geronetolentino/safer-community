				<div class="widget widget-content-area br-6 mb-4">
	    			<div class="widget-heading">
						<h5 class="">Resident</h5>
					</div>
	    			<div class="widget-content">
			        	<div class="text-center">
			        		<img src="{{ asset('img/default-avatar.png') }}" alt="{{ Auth::user()->name }}" style="width: 150px; border: 3px solid #3b405c; border-radius: 5px;" />
			        		<hr>
		        			<h5><strong>{{ Auth::user()->name }}</strong></h5>
		        			<h5><strong># {{ Auth::user()->uid }}</strong></h5>
		        			<hr>

			        	</div>
			        	{{-- <p>Overall Status: <strong>{{ Auth::user()->uid }}</strong></p> --}}
		        		<p>Latest Health Checklist: 
		        			@if ($latestCheckList)
		        			<strong class="text-{{ $latestCheckList->condition['color'] }}">{{ $latestCheckList->poi_condition }}</strong>
		        			@else 
		        			
		        			@endif
		        		</p>
			        </div>
    			</div>
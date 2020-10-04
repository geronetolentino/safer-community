<div class="widget widget-table-two br-6 mb-4">
		    <div class="widget-heading">
		        <h5 class="">Health Check History</h5>
		    </div>

		    <div class="widget-content">
		        <div class="table-responsive">
		            <table class="table">
		                <thead>
		                    <tr>
		                        <th><div class="th-content">Date</div></th>
		                        <th><div class="th-content">Symptoms Count</div></th>
		                        <th><div class="th-content">Status</div></th>
		                    </tr>
		                </thead>
		                <tbody>
		                	@forelse($historyCheckList as $history)
		                    <tr>
		                        <td>
		                            <div class="td-content customer-name">
		                            	<a href="" class="">{{ $history->date_submitted }}</a>
		                            </div>
		                        </td>
		                        <td class="float-left">
		                            <div class="td-content customer-name">
		                            	Serious Symptoms: <strong>{{ $history->serious_symptoms }}</strong> <br>
		                            	Less Common Symptoms: <strong>{{ $history->less_common_symptoms }}</strong>
		                            </div>
		                        </td>
		                        <td>
		                            <div class="td-content">
		                            	<span class="badge outline-badge-{{ $history->condition['color'] }}">{{ $history->condition['text'] }}</span>
		                            </div>
		                        </td>
		                    </tr>
		                    @empty
		                    <tr>
		                    	<td colspan="3">
		                            <div class="text-center">
		                            	<p><strong>No history found.</strong></p>
		                            </div>
		                    	</td>
		                    </tr>
		                    @endforelse
		                </tbody>
		            </table>
		        </div>
		    </div>
		</div>
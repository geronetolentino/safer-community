@extends('layouts.app')

@section('content')
<div class="row layout">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
        	<h4 class="mb-0"><strong>{{ $branch->name }}</strong> <br>
        		<small>[{{ $branch->account->fullAddress }}]</small>
        	</h4>
        	<h5 class="mb-0"><small>{{ $branch->est_code }}</small></h5>
			<div class="simple-tab">
				<ul class="nav nav-tabs mb-3 mt-3" id="simpletab" role="tablist">
				    <li class="nav-item">
				        <a class="nav-link active" id="dashboard-tab" data-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="true">Dashboard</a>
				    </li>
				    <li class="nav-item">
				        <a class="nav-link" id="visitor_log-tab" data-toggle="tab" href="#visitor_log" role="tab" aria-controls="visitor_log" aria-selected="false">Visitor Log</a>
				    </li>
				    <li class="nav-item">
				        <a class="nav-link" id="employee-tab" data-toggle="tab" href="#employee" role="tab" aria-controls="employee" aria-selected="false">Employees</a>
				    </li>
				    <li class="nav-item">
				        <a class="nav-link" id="scanner-tab" data-toggle="tab" href="#scanner" role="tab" aria-controls="scanner" aria-selected="false">Scanners</a>
				    </li>
				</ul>
				<div class="tab-content" id="simpletabContent">
				    <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">

						<div class="tabs tab-content">
							<div id="content_1" class="tabcontent">
								<div id="visitChart"></div>
							</div>
						</div> 
				    </div>
				    <div class="tab-pane fade" id="visitor_log" role="tabpanel" aria-labelledby="visitor_log-tab">

						<div class="table-responsive">
							<table class="visitor_log table table-hover" style="width: 100%;">
								<thead>
									<tr>
										<th>#</th>
										<th>Visitor</th>
										<th>Date</th>
										<th>Status</th>
										<th class="no-content">Action</th>
									</tr>
					    		</thead>
							    <tbody></tbody>
							    <tfoot>
							       	<tr>
							       		<th>ID</th>
							       		<th>Visitor</th>
							       		<th>Date</th>
							       		<th>Status</th>
							       		<th>Action</th>
							       	</tr>
							    </tfoot>
							</table>
						</div>
				    </div>
				    <div class="tab-pane fade" id="employee" role="tabpanel" aria-labelledby="employee-tab">

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
						                <button class="btn btn-primary btn-sm btn-status" data-eeid="{{ $pending->id }}" data-status="1">Approve</button>
						                <button class="btn btn-dark btn-sm btn-status" data-eeid="{{ $pending->id }}" data-status="0">Decline</button>
						            </div>
						        </div>
						    </li>
						    @endforeach
						</ul>

					    <div class="table-responsive ">
					    	<table class="employee table table-hover" style="width: 100%;">
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
				    <div class="tab-pane fade" id="scanner" role="tabpanel" aria-labelledby="scanner-tab">

					    <div class="table-responsive ">
					    	<table class="employee table table-hover" style="width: 100%;">
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

        $('.visitor_log').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('es.branch.visitor.list',['est_code'=>$branch->est_code]) }}',
            columns: [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'visitor', name: 'visitor' }, 
                { data: 'date', name: 'date' }, 
                { data: 'status', name: 'status' }, 
                { data: 'action', name: 'action' }, 
            ]
        });

        $('.employee').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('es.branch.employee.list',['id'=>$branch->id]) }}',
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

                            var dTable = $('.employee').dataTable();
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

	try {
	    var options1 = {
	        chart: {
	            fontFamily: "Nunito, sans-serif",
	            height: 500,
	            type: "area",
	            zoom: {
	                enabled: false,
	            },
	            dropShadow: {
	                enabled: true,
	                opacity: 0.3,
	                blur: 5,
	                left: -7,
	                top: 22,
	            },
	            toolbar: {
	                show: false,
	            },
	            // events: {
	            //     mounted: function (ctx, config) {
	            //         const highest1 = ctx.getHighestValueInSeries(0);
	            //         const highest2 = ctx.getHighestValueInSeries(1);

	            //         ctx.addPointAnnotation({
	            //             x: new Date(ctx.w.globals.seriesX[0][ctx.w.globals.series[0].indexOf(highest1)]).getTime(),
	            //             y: highest1,
	            //             label: {
	            //                 style: {
	            //                     cssClass: "d-none",
	            //                 },
	            //             },
	            //             customSVG: {
	            //                 SVG:
	            //                     '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#1b55e2" stroke="#fff" stroke-width="3" stroke-linecap="alert-circle" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
	            //                 cssClass: undefined,
	            //                 offsetX: -8,
	            //                 offsetY: 5,
	            //             },
	            //         });

	            //         ctx.addPointAnnotation({
	            //             x: new Date(ctx.w.globals.seriesX[1][ctx.w.globals.series[1].indexOf(highest2)]).getTime(),
	            //             y: highest2,
	            //             label: {
	            //                 style: {
	            //                     cssClass: "d-none",
	            //                 },
	            //             },
	            //             customSVG: {
	            //                 SVG:
	            //                     '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#e7515a" stroke="#fff" stroke-width="3" stroke-linecap="alert-circle" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
	            //                 cssClass: undefined,
	            //                 offsetX: -8,
	            //                 offsetY: 5,
	            //             },
	            //         });
	            //     },
	            // },
	        },
	        colors: ["#1b55e2", "#e7515a"],
	        dataLabels: {
	            enabled: false,
	        },
	        markers: {
	            discrete: [
	                {
	                    seriesIndex: 0,
	                    dataPointIndex: 7,
	                    fillColor: "#000",
	                    strokeColor: "#000",
	                    size: 5,
	                },
	                {
	                    seriesIndex: 2,
	                    dataPointIndex: 11,
	                    fillColor: "#000",
	                    strokeColor: "#000",
	                    size: 4,
	                },
	            ],
	        },
	        subtitle: {
	            text: "Using QR code scanner",
	            align: "left",
	            margin: 0,
	            offsetX: -10,
	            offsetY: 35,
	            floating: false,
	            style: {
	                fontSize: "14px",
	                color: "#888ea8",
	            },
	        },
	        title: {
	            text: "Total Visitors",
	            align: "left",
	            margin: 0,
	            offsetX: -10,
	            offsetY: 0,
	            floating: false,
	            style: {
	                fontSize: "25px",
	                color: "#0e1726",
	            },
	        },
	        stroke: {
	            show: true,
	            curve: "smooth",
	            width: 2,
	            lineCap: "square",
	        },
	        series: [
	            {
	                name: "Visitors",
	                data: [0, 0, 0, 0, 0, 0, 0, 0, 0],
	            },
	            // {
	            //     name: "Female",
	            //     data: [16500, 17500, 16200, 17300, 16000, 19500],
	            // },
	            // {
	            //     name: "Female",
	            //     data: [16500, 17500, 16200, 17300, 16000, 19500],
	            // },
	            // {
	            //     name: "Female",
	            //     data: [16500, 17500, 16200, 17300, 16000, 19500],
	            // },
	        ],
	        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep"],
	        xaxis: {
	            axisBorder: {
	                show: false,
	            },
	            axisTicks: {
	                show: false,
	            },
	            crosshairs: {
	                show: true,
	            },
	            labels: {
	                offsetX: 0,
	                offsetY: 5,
	                style: {
	                    fontSize: "12px",
	                    fontFamily: "Nunito, sans-serif",
	                    cssClass: "apexcharts-xaxis-title",
	                },
	            },
	        },
	        yaxis: {
	            labels: {
	                formatter: function (value, index) {
	                    return value / 1000 + "K";
	                },
	                offsetX: -22,
	                offsetY: 0,
	                style: {
	                    fontSize: "12px",
	                    fontFamily: "Nunito, sans-serif",
	                    cssClass: "apexcharts-yaxis-title",
	                },
	            },
	        },
	        grid: {
	            borderColor: "#e0e6ed",
	            strokeDashArray: 5,
	            xaxis: {
	                lines: {
	                    show: true,
	                },
	            },
	            yaxis: {
	                lines: {
	                    show: false,
	                },
	            },
	            padding: {
	                top: 0,
	                right: 0,
	                bottom: 0,
	                left: -10,
	            },
	        },
	        legend: {
	            position: "top",
	            horizontalAlign: "right",
	            offsetY: -50,
	            fontSize: "16px",
	            fontFamily: "Nunito, sans-serif",
	            markers: {
	                width: 10,
	                height: 10,
	                strokeWidth: 0,
	                strokeColor: "#fff",
	                fillColors: undefined,
	                radius: 12,
	                onClick: undefined,
	                offsetX: 0,
	                offsetY: 0,
	            },
	            itemMargin: {
	                horizontal: 0,
	                vertical: 20,
	            },
	        },
	        tooltip: {
	            theme: "dark",
	            marker: {
	                show: true,
	            },
	            x: {
	                show: false,
	            },
	        },
	        fill: {
	            type: "gradient",
	            gradient: {
	                type: "vertical",
	                shadeIntensity: 1,
	                inverseColors: !1,
	                opacityFrom: 0.28,
	                opacityTo: 0.05,
	                stops: [45, 100],
	            },
	        },
	        responsive: [
	            {
	                breakpoint: 575,
	                options: {
	                    legend: {
	                        offsetY: -30,
	                    },
	                },
	            },
	        ],
	    };

	    var chart1 = new ApexCharts(document.querySelector("#visitChart"), options1);

	    chart1.render();
	} catch (e) {
	    // statements
	    console.log(e);
	}
</script>
@endpush
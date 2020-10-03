@extends('layouts.app') @section('content')

<div class="row layout-spacing">
    <div class="col-xl-3 col-lg-6 col-md-4 col-sm-12 layout-top-spacing">
        @include('establishment.branch.single.profile-nav')
    </div>
    <div class="col-xl-9 col-lg-6 col-md-8 col-sm-12 layout-top-spacing">
        <div class="widget-content-area">
            <div class="widget-content">
                <button class="btn btn-primary mb-2 mr-2 assign-employee">
                    <i data-feather="plus-circle"></i>
                    Assign Employee
                </button>
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
                                <th>#</th>
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

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">ModalTitle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-9 filtered-list-search mx-auto">
                        <div class="w-100">
                            <input type="text" class="w-100 form-control product-search br-30" id="input-search" placeholder="Search Undeployed Employee..." />
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="searchable-container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="searchable-items" style="max-height: 500px; min-height: 500px;">
                                        @foreach($employees as $employee)
                                        <div class="items" id="{{ $employee->resident->id }}">
                                            <div class="user-profile">
                                                <img src="{{ route('image.process',['filename'=>$employee->resident->info->profile_photo]) }}" />
                                            </div>
                                            <div class="user-name">
                                                <p>{{ $employee->resident->info->poi_id }}</p>
                                            </div>
                                            <div class="action-btn">
                                                <button type="button" class="btn btn-sm btn-primary deploy" data-id="{{ $employee->resident->id }}">Deploy here</button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">
                    <i class="flaticon-cancel-12"></i>
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

@endsection @push('styles')
<link href="{{ asset('css/widgets/modules-widgets.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/elements/search.css') }}" rel="stylesheet" type="text/css" />
@endpush @push('scripts')
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
            ajax: '{{ route('es.branch.single.assigned.employee.list',['est_code'=>$branch->est_code]) }}',
            columns: [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'employee', name: 'employee' },
                { data: 'address', name: 'address' },
                { data: 'health_status', name: 'health_status' },
                { data: 'action', name: 'action' },
            ]
        });

        $('body').on('click', '.assign-employee', function() {
            $('#modalTitle').text("Assign Employee to "+$('.branch-name').text());
            $('#modal').modal({backdrop: 'static', keyboard: false});
        });

        $('body').on('click', '.undeploy', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: "Undeploy Employee",
                text: "Do you want to undeploy employee to current branch.",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Undeploy",
                cancelButtonText: "Cancel",
                buttonsStyling: true
            }).then((result) => {
                if (result.isConfirmed) {
                    deployEmployee(id,'undeploy');
                }
            });
        });

        $('body').on('click', '.deploy', function() {
            var id = $(this).data('id');

            Swal.fire({
                title: "Deploy Employee",
                text: "Do you want to deploy employee to current branch.",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Deploy",
                cancelButtonText: "Cancel",
                buttonsStyling: true
            }).then((result) => {
                if (result.isConfirmed) {
                    deployEmployee(id,'deploy');
                }
            });

        });

        $('#input-search').on('keyup', function() {
          var rex = new RegExp($(this).val(), 'i');
            $('.searchable-container .items').hide();
            $('.searchable-container .items').filter(function() {
                return rex.test($(this).text());
            }).show();
        });

        function deployEmployee(id, status) {
            $.ajax({
                type: "POST",
                url: "{{ route('es.branch.single.employee.deploy',['est_code'=>$branch->est_code]) }}",
                data: {
                    id: id,
                    status: status
                },
                dataType: 'json',
                success: function(response) {

                    Swal.fire({
                        title: "Deploy Status",
                        text: response.message,
                        icon: response.status
                    });

                    // if (status == 'undeploy') {
                    //     $('div.searchable-items').append('');
                    // }
                    if (status == 'deploy' || response.status == 'warning') {
                        $('div#'+id).remove();
                    }

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
</script>
@endpush
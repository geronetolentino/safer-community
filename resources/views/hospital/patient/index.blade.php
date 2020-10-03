@extends('layouts.app')

@section('content')

<div class="row layout-top-spacing">
    <div class="col-md-4">
        <button class="btn btn-primary mb-2 mr-2 create">
            <i data-feather="plus-circle"></i> 
            Add Patient
        </button>
    </div>
    <div class="col-md-8"></div>
</div>

<div class="row layout">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive">
                <table class="style-3 table table-bordered table-hover table-striped mb-4 datatable" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Patient</th>
                            <th>Status</th>
                            <th class="no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
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
                            <input type="text" class="w-100 form-control product-search br-30" id="input-search" placeholder="Search POI..." />
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="searchable-container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="searchable-items" style="max-height: 500px; min-height: 500px;">
                                        @foreach($residents as $resident)
                                        <div class="items" id="{{ $resident->info->poi_id }}">
                                            <div class="user-email">
                                                <p>{{ $resident->info->poi_id??$resident->name }}</p>
                                            </div>
                                            <div class="action-btn">
                                                <button type="button" class="btn btn-sm btn-primary add-patient" data-id="{{ $resident->info->poi_id }}">Add to Patients</button>
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


{{-- <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="modalForm" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">ModalTitle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-5">
                                <input type="text" class="form-control" placeholder="POI #" aria-label="POI #" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary">
                                        Search
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">
                        <i class="flaticon-cancel-12"></i> 
                        Close
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

@endsection

@push('styles')
<link href="{{ asset('css/components/custom-list-group.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/widgets/modules-widgets.css') }}" rel="stylesheet" type="text/css"> 
<link href="{{ asset('css/elements/search.css') }}" rel="stylesheet" type="text/css" /> 
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('hp.patient.list') }}',
            columns: [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'patient', name: 'patient' }, 
                { data: 'status', name: 'status' }, 
                { data: 'action', name: 'action' }, 
            ],
        });

        // $('body').on('click', '.create', function() {
        //     $('#id').val('');
        //     $('#modalForm').trigger("reset");
        //     $('#modalTitle').text("Add Patients");
        //     $('#modal').modal({backdrop: 'static', keyboard: false});
        // });
        $('body').on('click', '.create', function() {
            $('#modalTitle').text("Add Patients");
            $('#modal').modal({backdrop: 'static', keyboard: false});
        });

        $('body').on('click', '.add-patient', function() {
            var id = $(this).data('id');
            
            Swal.fire({
                title: "Add Patient",
                text: "Do you want to add the POI to patients list.",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Add Patient",
                cancelButtonText: "Cancel",
                buttonsStyling: true
            }).then((result) => {  
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('hp.patient.add') }}",
                        data: { 
                            id: id
                        },
                        dataType: 'json',
                        success: function(response) {

                            Swal.fire({
                                title: "Add Patient",
                                text: response.message,
                                icon: response.status
                            });

                            $('#'+id).remove();
                            
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

        $('#input-search').on('keyup', function() {
          var rex = new RegExp($(this).val(), 'i');
            $('.searchable-container .items').hide();
            $('.searchable-container .items').filter(function() {
                return rex.test($(this).text());
            }).show();
        });
    });
 
</script>

@endpush
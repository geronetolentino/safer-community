@extends('layouts.app')

@section('content')

<div class="row layout-spacing">
    <div class="col-xl-3 col-lg-6 col-md-4 col-sm-12 layout-top-spacing">
        @include('establishment.branch.single.profile-nav')
    </div>
    <div class="col-xl-9 col-lg-6 col-md-8 col-sm-12 layout-top-spacing">
        <div class="widget-content-area">
            <div class="widget-content">

                <button class="btn btn-primary mb-2 mr-2 create">
                    <i data-feather="plus-circle"></i> 
                    Add Scanner
                </button>

                <div class="table-responsive">
                    <table class="datatable table table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Scanner Name</th>
                                <th>Status</th>
                                <th>Assigned to</th>
                                <th class="no-content">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Scanner Name</th>
                                <th>Status</th>
                                <th>Assigned to</th>
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
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="modalForm" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">ModalTitle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="action" id="action">
                    <div class="form-group">
                        <label for="name">Scanner Name</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name" required="" placeholder="Type here...">
                    </div> 

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="0">Offline</option>
                            <option value="1">Online</option>
                        </select>
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

<div class="modal fade" id="assign-modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="modalForm2" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle2">ModalTitle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="scanner_id" id="scanner_id">

                    <div class="form-group">
                        <label for="employee_id">Branch Assigned Employee</label>
                        <select class="form-control" id="employee_id" name="employee_id">
                            <option value="0">Vacant</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->resident->name }}</option>
                            @endforeach
                        </select>
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

@endsection

@push('styles')
<link href="{{ asset('css/widgets/modules-widgets.css') }}" rel="stylesheet" type="text/css">  
@endpush

@push('scripts')
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
            ajax: '{{ route('es.branch.single.scanner.list',['est_code'=>$branch->est_code]) }}',
            columns: [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'name', name: 'name' }, 
                { data: 'status', name: 'status' }, 
                { data: 'assigned_to', name: 'assigned_to' }, 
                { data: 'action', name: 'action' }, 
            ],
        });

        $('body').on('click', '.create', function() {
            $('#action').val('create');
            $('#id').val('');
            $('#modalForm').trigger("reset");
            $('#modalTitle').text("Add Scanner");
            $('#modal').modal({backdrop: 'static', keyboard: false});
        });

        $('body').on('click', '.edit', function() {
            var id = $(this).data('id'); 
            $('#action').val('update');
            $('#id').val(id);
            $.get("{{ route('es.branch.single.scanner.show',['est_code'=>$branch->est_code]) }}", { id: id } , function(data) {
                $('#modalTitle').text("Update Scanner");
                $('#modal').modal('show');

                $("#name").val(data.name);
                $("#status").val(data.status).change();
            })
        });

        $('body').on('click', '.assign-btn', function() {
            var id = $(this).data('id'),
                scanner = $(this).data('scanner'),
                employee = $(this).data('employee'); 

            $('#scanner_id').val(id);
            
            $('#modalTitle2').text("Update Scanner: "+scanner);
            $('#assign-modal').modal({backdrop: 'static', keyboard: false});
            $("#employee_id").val(employee).change();
        });

    });

    if ($("#modalForm").length > 0) {

        $('#modalForm').validate({
            rules: {
                id: "",
                name: "required",
                status: "required",
            },
            messages: {
                id: "",
                name: "This field is required",
                status: "This field is required",
            },
            errorElement: "div",
            submitHandler: function() {
                var url = $('#action').val() == 'create'?'{{ route('es.branch.single.scanner.store',['est_code'=>$branch->est_code]) }}':'{{ route('es.branch.single.scanner.update',['est_code'=>$branch->est_code]) }}';
                $('.submit').attr('disabled', true);
                  
                $.ajax({
                    data: $('#modalForm').serialize(),
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {

                        $('.submit').attr('disabled', false);
                        var dTable = $('.datatable').dataTable();
                        dTable.fnDraw(false);
                        
                        Swal.fire({
                            title: data.message, 
                            icon: data.status,
                            confirmButtonText: 'Close'
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('.submit').attr('disabled', false);
                    }
                });

            }
        });
    } 

    if ($("#modalForm2").length > 0) {

        $('#modalForm2').validate({
            rules: {
                scanner_id: "",
                employee_id: "required",
            },
            messages: {
                scanner_id: "This field is required",
                employee_id: "This field is required",
            },
            errorElement: "div",
            submitHandler: function() {
                $('.submit').attr('disabled', true);
                  
                $.ajax({
                    data: $('#modalForm2').serialize(),
                    url: '{{ route('es.branch.single.scanner.assign',['est_code'=>$branch->est_code]) }}',
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {

                        $('.submit').attr('disabled', false);
                        var dTable = $('.datatable').dataTable();
                        dTable.fnDraw(false);
                        
                        Swal.fire({
                            title: data.message, 
                            icon: data.status,
                            confirmButtonText: 'Close'
                        });
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
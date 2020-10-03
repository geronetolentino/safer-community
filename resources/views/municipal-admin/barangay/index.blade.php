@extends('layouts.app')

@section('content')

<div class="row layout-top-spacing">
    <div class="col-md-4">
        <button class="btn btn-primary mb-2 mr-2 create">
            <i data-feather="plus-circle"></i> 
            Add Barangay
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
                            <th>Barangay</th>
                            <th>Residents</th>
                            <th>Account</th>
                            <th class="no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Barangay</th>
                            <th>Residents</th>
                            <th>Account</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
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
                    <div class="form-group">
                        <label for="code">Barangay Code</label>
                        <input type="text" class="form-control form-control-sm" id="code" name="code" required="" placeholder="Type here...">
                    </div> 
                    <div class="form-group">
                        <label for="barangay">Barangay</label>
                        <input type="text" class="form-control form-control-sm" id="barangay" name="barangay" required="" placeholder="Type here...">
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
            ajax: '{{ route('ma.barangay.list') }}',
            columns: [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'barangay', name: 'barangay' }, 
                { data: 'resident', name: 'resident' }, 
                { data: 'account', name: 'account' }, 
                { data: 'action', name: 'action' }, 
            ],
        });

        $('body').on('click', '.create', function() {
            $('#id').val('');
            $('#modalForm').trigger("reset");
            $('#modalTitle').text("Add Barangay");
            $('#modal').modal({backdrop: 'static', keyboard: false});
        });

        $('body').on('click', '.account-btn', function() {
            var id = $(this).data('id'),
                action = $(this).data('action'),
                text = action=='create'?'Do you want to create account?':'Do you want to reset account?';

            Swal.fire({
                title: "Account",
                text: text,
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                buttonsStyling: true
            }).then((result) => {  
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('ma.barangay.account') }}",
                        data: { 
                            id: id,
                            action: action
                        },
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire({
                                title: "Account Generated!",
                                html: `Username: <strong>${response.data.username}</strong><br>Password: <strong>${response.data.password}</strong>`,
                                icon: "success"
                            });
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
    });

    if ($("#modalForm").length > 0) {

        $('#modalForm').validate({
            rules: {
                code: "required",
                barangay: "required",
            },
            messages: {
                code: "This field is required",
                barangay: "This field is required",
            },
            errorElement: "div",
            submitHandler: function() {

                $('.submit').attr('disabled', true);
                  
                $.ajax({
                    data: $('#modalForm').serialize(),
                    url: "{{ route('ma.barangay.store') }}",
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
             
                        if (data.status == 'success') {
                            $('#modalForm').trigger("reset");
                        }

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
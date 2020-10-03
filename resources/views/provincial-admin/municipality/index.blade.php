@extends('layouts.app')

@section('content')

<div class="row layout-top-spacing">
    <div class="col-md-4">
        <button class="btn btn-primary mb-2 mr-2 create">
            <i data-feather="plus-circle"></i> 
            Add Municipality
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
                            <th>Municipality/City</th>
                            <th>Barangay</th>
                            <th>Community</th>
                            <th>Account</th>
                            <th class="no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Municipality/City</th>
                            <th>Barangay</th>
                            <th>Community</th>
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
                        <label for="code">Municipality/City Code</label>
                        <input type="text" class="form-control form-control-sm" id="code" name="code" required="" placeholder="Type here...">
                    </div> 
                    <div class="form-group">
                        <label for="municipality">Municipality/City Desc.</label>
                        <input type="text" class="form-control form-control-sm" id="municipality" name="municipality" required="" placeholder="Type here...">
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
            ajax: '{{ route('pa.municipality.list') }}',
            columns: [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'municipality', name: 'municipality' }, 
                { data: 'barangay', name: 'barangay' }, 
                { data: 'community', name: 'community' }, 
                { data: 'account', name: 'account' }, 
                { data: 'action', name: 'action' }, 
            ],
        });

        $('body').on('click', '.create', function() {
            $('#id').val('');
            $('#modalForm').trigger("reset");
            $('#modalTitle').text("Add Municipality/City");
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
                        url: "{{ route('pa.municipality.account') }}",
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
                municipality: "required",
            },
            messages: {
                code: "This field is required",
                municipality: "This field is required",
            },
            errorElement: "div",
            submitHandler: function() {

                $('.submit').attr('disabled', true);
                  
                $.ajax({
                    data: $('#modalForm').serialize(),
                    url: "{{ route('pa.municipality.store') }}",
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {

                        Swal.fire({
                            title: "Create municipality/city account",
                            text: data.message,
                            icon: data.status
                        });
             
                        if (data.status == 'success') {
                            $('#modalForm').trigger("reset");
                        }

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
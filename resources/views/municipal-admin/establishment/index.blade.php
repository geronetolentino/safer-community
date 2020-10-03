@extends('layouts.app')

@section('content')

{{-- <div class="row layout-top-spacing">
    <div class="col-md-4">
        <button class="btn btn-primary mb-2 mr-2 create">
            <i data-feather="plus-circle"></i> 
            Add Establishment
        </button>
    </div>
    <div class="col-md-8"></div>
</div> --}}

<div class="row layout">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive">
                <table class="style-3 table table-bordered table-hover table-striped mb-4 datatable" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Establishment</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th class="no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Establishment</th>
                            <th>Address</th>
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

                    <div class="al"></div>

                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name">Establishment</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name" required="" placeholder="Type here...">
                    </div> 
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control form-control-sm" id="address" name="address" required="" placeholder="Type here...">
                    </div> 
                    <div class="form-group">
                        <label for="sel1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="1">Activate</option>
                            <option  value="0">de-Activate</option>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="hospital">Email</label>
                        <input type="text" class="form-control form-control-sm" id="email" name="email" required="" placeholder="Type here...">
                    </div> 
                    <div class="form-group">
                        <label for="hospital">Password</label>
                        <input type="text" class="form-control form-control-sm" id="password" name="password" required="" placeholder="Type here...">
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
            ajax: '{{ route('ma.establishment.list') }}',
            columns: [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'establishment', name: 'establishment' }, 
                { data: 'address', name: 'address' }, 
                { data: 'status', name: 'status'},
                { data: 'action', name: 'action' }, 
            ],
        });

        $('body').on('click', '.create', function() {
            $('#id').val('');
            $('#modalForm').trigger("reset");
            $('#modalTitle').text("Add Establishment");
            $('#modal').modal({backdrop: 'static', keyboard: false});
        });
    });

    if ($("#modalForm").length > 0) {

        $('#modalForm').validate({
            rules: {
                name: "required",
            },
            messages: {
                name: "This field is required",
            },
            errorElement: "div",
            // highlight: function(element, errorClass, validClass) {
            //     $(element).addClass("is-invalid");
            //     $(element).next("div").addClass("invalid-feedback");
            // },
            // unhighlight: function(element, errorClass, validClass) {
            //     $(element).removeClass("is-invalid");
            //     $(element).next("div").removeClass("invalid-feedback").hide();
            // },
            submitHandler: function() {

                $('.submit').attr('disabled', true);
                  
                $.ajax({
                    data: $('#modalForm').serialize(),
                    url: "{{ route('ma.establishment.store') }}",
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
             
                        if (data.status == 'success') {
                            $('#modalForm').trigger("reset");
                        }

                        $('.submit').attr('disabled', false);
                        var dTable = $('.datatable').dataTable();
                        dTable.fnDraw(false);
                        
                        $('.al').html('<div class="alert alert-'+data.status+' mb-4" role="alert">'+data.message+'</div>');
                        $('.alert').delay(5000).fadeOut();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('.submit').attr('disabled', false);
                    }
                });

                // ad here

            }
        });
    }  
</script>

@endpush
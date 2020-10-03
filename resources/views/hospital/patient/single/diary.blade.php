@extends('layouts.app')

@section('content')

<div class="row layout-spacing">
    <div class="col-xl-3 col-lg-6 col-md-4 col-sm-12 layout-top-spacing">
        @include('hospital.patient.single.profile-nav')
    </div>
    <div class="col-xl-9 col-lg-6 col-md-8 col-sm-12 layout-top-spacing sales">

        <div class="widget-content-area widget-chart-one">
            <div class="widget-heading">
                <h5>Health Test Diary Table</h5>
                <button class="btn btn-primary mb-2 mr-2 float-right add-diary-item">
                    <i data-feather="plus-circle"></i> 
                    Add Diary Item
                </button>
            </div>
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="datatable table table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Data Date</th>
                                <th>Procedures</th>
                                <th>Diagnosis</th>
                                <th>Note</th>
                                <th class="no-content">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Data Date</th>
                                <th>Procedures</th>
                                <th>Diagnosis</th>
                                <th>Note</th>
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
                    <div class="form-group">
                        <label for="data_date">Data Date</label>
                        <input type="text" class="form-control form-control-sm flatpickr flatpickr-input" id="data_date" name="data_date" required="" placeholder="Type here...">
                    </div> 
                    <div class="form-group">
                        <label for="procedures">Procedure</label>
                        <textarea class="form-control" id="procedures" name="procedures" rows="3"></textarea>
                    </div> 
                    <div class="form-group">
                        <label for="diagnosis">Diagnosis</label>
                        <textarea class="form-control" id="diagnosis" name="diagnosis" rows="3"></textarea>
                    </div> 
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
            ajax: "{{ route('hp.patient.health.test.diary.list',['poi_id'=>$patient->poi_id,'test_id'=>$test_id]) }}",
            columns: [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'data_date', name: 'data_date' }, 
                { data: 'procedures', name: 'procedures' }, 
                { data: 'diagnosis', name: 'diagnosis' }, 
                { data: 'note', name: 'note' }, 
                { data: 'action', name: 'action' }, 
            ]
        });

        $('body').on('click', '.add-diary-item', function() {
            $('#modalTitle').text("Add Health Test Diary");
            $('#modal').modal({backdrop: 'static', keyboard: false});
        });

        flatpickr(".flatpickr", {
            dateFormat: "Y-m-d"
        });
    });

    if ($("#modalForm").length > 0) {

        $('#modalForm').validate({
            rules: {
                data_date: "required",
                procedures: "required",
                diagnosis: "required",
                note: "required",
            },
            messages: {
                data_date: "This field is required",
                procedures: "This field is required",
                diagnosis: "This field is required",
                note: "This field is required",
            },
            errorElement: "div",
            submitHandler: function() {

                $('.submit').attr('disabled', true);
                  
                $.ajax({
                    data: $('#modalForm').serialize(),
                    url: "{{ route('hp.patient.health.test.diary.store',['poi_id'=>$patient->poi_id,'test_id'=>$test_id]) }}",
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
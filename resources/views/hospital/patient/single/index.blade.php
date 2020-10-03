@extends('layouts.app')

@section('content')

<div class="row layout-spacing">
    <div class="col-xl-3 col-lg-6 col-md-4 col-sm-12 layout-top-spacing">
        @include('hospital.patient.single.profile-nav')
    </div>
    <div class="col-xl-9 col-lg-6 col-md-8 col-sm-12 layout-top-spacing sales">
        <div class="widget-content-area widget-chart-one">
            <div class="widget-heading">
                <h5>Health Test Table</h5>
                <button class="btn btn-primary mb-2 float-right add-test">
                    <i data-feather="plus-circle"></i> 
                    Add Test
                </button>
            </div>
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="datatable table table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Test Date</th>
                                <th>Result</th>
                                <th>Symptom Category</th>
                                <th>Remarks</th>
                                <th class="no-content">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Test Date</th>
                                <th>Result</th>
                                <th>Symptom Category</th>
                                <th>Remarks</th>
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
                        <label for="test_date">Test Date</label>
                    
                        <input class="form-control form-control-sm flatpickr flatpickr-input" type="text" id="test_date" name="test_date" placeholder="Select Date..">
                    </div> 
                    <div class="form-group">
                        <label for="test_result">Test Result</label>
                        <input type="text" class="form-control form-control-sm" id="test_result" name="test_result" required="" placeholder="Type here...">
                    </div> 
                    <div class="form-group">
                        <label for="symptom_category">Symptom Category</label>
                        <input type="text" class="form-control form-control-sm" id="symptom_category" name="symptom_category" required="" placeholder="Type here...">
                    </div> 
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <input type="text" class="form-control form-control-sm" id="remarks" name="remarks" required="" placeholder="Type here...">
                    </div>
                   {{--  <div class="form-group">
                        <div class="n-chk">
                            <label class="new-control new-checkbox checkbox-primary">
                              <input type="checkbox" class="new-control-input">
                              <span class="new-control-indicator"></span> &nbsp;
                              Set as Current Status
                            </label>
                        </div>
                    </div> --}}
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
            ajax: "{{ route('hp.patient.health.test.list',['poi_id'=>$patient->poi_id]) }}",
            columns: [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'test_date', name: 'test_date' }, 
                { data: 'test_result', name: 'test_result' }, 
                { data: 'symptom_category', name: 'symptom_category' }, 
                { data: 'remarks', name: 'remarks' }, 
                { data: 'action', name: 'action' }, 
            ]
        });

        $('body').on('click', '.add-test', function() {
            $('#modalTitle').text("Add Health Test");
            $('#modal').modal({backdrop: 'static', keyboard: false});
        });

        flatpickr(".flatpickr", {
            dateFormat: "Y-m-d"
        });
    });

    if ($("#modalForm").length > 0) {

        $('#modalForm').validate({
            rules: {
                test_date: "required",
                test_result: "required",
                symptom_category: "required",
                remarks: "required",
            },
            messages: {
                test_date: "This field is required",
                test_result: "This field is required",
                symptom_category: "This field is required",
                remarks: "This field is required",
            },
            errorElement: "div",
            submitHandler: function() {

                $('.submit').attr('disabled', true);
                  
                $.ajax({
                    data: $('#modalForm').serialize(),
                    url: "{{ route('hp.patient.health.test.store',['poi_id'=>$patient->poi_id]) }}",
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
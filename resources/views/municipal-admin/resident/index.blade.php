@extends('layouts.app')

@section('content')

<div class="row layout-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive">
                <table class="datatable table table-hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Resident</th>
                            <th>Documents</th>
                            <th>Barangay</th>
                            <th>Health Status</th>
                            <th class="no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Resident</th>
                            <th>Documents</th>
                            <th>Barangay</th>
                            <th>Health Status</th>
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
                        <label for="barangay">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="PUM">PUM</option>
                            <option value="PUI">PUI</option>
                            <option value="Covid-19 Positive">Covid-19 Positive</option>
                        </select>
                    </div> 

                    <p class="text-muted"><strong>NOTE:</strong> setting POI health status will automatically set POI under <b>quarantine for 14 to 21 days</b>. <br> After 14 days system will automatically reset health status.</p>
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
            ajax: '{{ route('ma.resident.list') }}',
            columns: [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'resident', name: 'resident' }, 
                { data: 'documents', name: 'documents' }, 
                { data: 'barangay', name: 'barangay' }, 
                { data: 'health_status', name: 'health_status' }, 
                { data: 'action', name: 'action' }, 
            ]
        });

        $('body').on('click', '.set-health-status', function() {
            var id = $(this).data('id');

            $('#modalForm').trigger("reset");
            $('#modalTitle').text("Set Health Status");
            $('#modal').modal({backdrop: 'static', keyboard: false});
            $('#id').val(id);

        });
    });
</script>

@endpush
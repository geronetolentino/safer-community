@extends('layouts.app')

@section('content')

<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive mb-4 mt-4">
                <table class="datatable table table-hover" style="width: 100%;">
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
            ajax: '{{ route('es.visitor.list') }}',
            columns: [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'visitor', name: 'visitor' }, 
                { data: 'date', name: 'date' }, 
                { data: 'status', name: 'status' }, 
                { data: 'action', name: 'action' }, 
            ]
            
        });
    });
</script>

@endpush
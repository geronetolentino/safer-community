@extends('layouts.app')

@section('content')

<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive mb-4 mt-4">
                <table class="datatable table table-hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Date of Visit</th>
                            <th>Visitor</th>
                            <th>Reason of Visit</th>
                            <th>Travel History</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th class="no-content"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th>Date of Visit</th>
                            <th>Visitor</th>
                            <th>Reason of Visit</th>
                            <th>Travel History</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th></th>
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
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('pa.visitor.list') }}',
        });
    });
</script>

@endpush
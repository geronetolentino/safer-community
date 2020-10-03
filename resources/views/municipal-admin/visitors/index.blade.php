@extends('layouts.app')

@section('content')

<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive mb-4 mt-4">
                <table class="datatable table table-hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>visitor</th>
                            <th>reason of visit</th>
                            <th>created at</th>
                            <th>status</th>
                        </tr>
                    </thead></tbody>
                    <tfoot>
                        <tr>
                            <th>Visitor</th>
                            <th>Reason of Visit</th>
                            <th>Created At</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link href="{{ asset('plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('ma.visitors.list') }}',
            columns: [
                { data: 'visitor', name: 'visitor' },
                { data: 'reason_of_visit', name: 'reason_of_visit' },
                { data: 'created_at', name: 'created_at' },
                { data: 'status', name: 'status' },
            ],
            order: [[0, 'asc']],
            ordering: false,
            info: false,
            pageLength: 10 
        });
        
        function error(message) {
            swal({
              title: 'Error!',
              text: message,
              type: 'error',
              padding: '2em'
            });
        }

        function success(message) {
            swal({
              title: 'Success!',
              text: message,
              type: 'success',
              padding: '2em'
            });
        }
        @if (session('error'))
            error("{{ session('error') }}");
        @endif

        @if (session('success'))
            success("{{ session('success') }}");
        @endif
    });
</script>

@endpush
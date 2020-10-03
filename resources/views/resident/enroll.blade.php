@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">

        	<div class="text-center">

                <img src="{{ route('image.process',['filename'=>$establishment->account->info->profile_photo]) }}" width="150px">
                <h2 class="mb-5">
                    {{ $establishment->name }} 
                    <br>
                    <small>{{ $establishment->account->fullAddress }} </small>
                </h2>

                @if($warning)

                <div class="alert alert-warning mb-4" role="alert">
                    <strong>Oops!</strong> 
                    Please use a resident account to enroll as employee.
                </div> 

                @else

                    @if($existing)
                    <div class="alert alert-warning mb-4" role="alert">
                        <strong>Oops!</strong> 
                        Our system detected that you are current employed. <br>
                        Please call your current employeer (admin).
                    </div>     
                    @else
            		<p>
                        <strong>Please click submit if you want to enroll as employee to {{ $establishment->name }}.</strong>
                    </p>

            		<a href="{{ route('home') }}" class="btn btn-dark">Return to home</a>
            		<button class="btn btn-primary confirm-enroll" data-id="{{ $establishment->user_id }}">Submit</button>
                    @endif

                @endif
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
        $('body').on('click', '.confirm-enroll', function() {
        	var id = $(this).data('id');

       		Swal.fire({
                title: "Enroll as employee",
                text: 'Please confirm to continue.',
                icon: "question",
                reverseButtons: true,
                showCancelButton: true,
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                buttonsStyling: true
            }).then((result) => {  
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('employee.enroll.confirm') }}",
                        data: { 
                            id: id
                        },
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire({
                                title: "Enroll as employee",
                                text: response.message,
                                icon: response.status
                            }).then((result) => {  
                                if (result.isConfirmed) {
                                    window.location="{{ route('home') }}";
                                }
                            });
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
</script>
@endpush
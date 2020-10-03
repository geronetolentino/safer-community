@extends('layouts.app')

@section('content')

@if(Auth::user()->establishment->parent_id == 0)
<div class="row layout-top-spacing">
    <div class="col-md-4">
        <button class="btn btn-primary mb-2 mr-2 create">
            <i data-feather="plus-circle"></i> 
            Add Branch
        </button>
    </div>
    <div class="col-md-8"></div>
</div>
@endif

<div class="row layout">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area">

            <div class="row">
                @foreach($establishments as $establishment)
            
                <div class="col-md-3">
                    <div class="card">
                        <img src="{{ route('image.process.establishment',['filename'=>$establishment->logo]) }}" class="card-img-top" alt="widget-card-2" />
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ $establishment->name }}
                                @if($establishment->parent_id == 0)
                                <small class="font-bold text-muted">[Main Branch]</small>
                                @endif
                            </h5>
                            
                            <p class="card-text mb-0 ellipsis bs-tooltip" title="Establishment Code/Location ID">Code: <strong>{{ $establishment->est_code }}</strong></p>
                            <p class="card-text mb-0 ellipsis bs-tooltip" title="{{ $establishment->account->fullAddress }}">Address: <strong>{{ $establishment->account->fullAddress }}</strong></p>
                            <p class="card-text mb-0">Employees: <strong>{{ $establishment->employees->count() }}</strong></p>
                            <p class="card-text mb-0">Scanners: <strong>{{ $establishment->scanners->count() }}</strong></p>
                            
                            @if ($establishment->account) 
                                <a href="javascript:void(0);" class="btn btn-sm btn-danger account-btn mt-3" data-id="{{ $establishment->account->id }}" data-action="reset" title="Reset {{ $establishment->account->username }}">
                                    <i data-feather="user"></i>
                                </a>
                            @else
                                <a href="javascript:void(0);" class="btn btn-sm btn-info account-btn mt-3" data-id="{{ $establishment->account->id }}" data-action="create" title="Create Account">
                                    <i data-feather="user"></i>
                                </a>
                            @endif

                            <a href="{{ route('es.branch.single',['est_code'=>$establishment->est_code]) }}" class="btn btn-sm btn-primary mt-3">
                                View
                                <i data-feather="arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
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
                        <label for="addr_region_id">Region</label>
                        <select class="custom-select" name="addr_region_id" id="addr_region_id" required="">
                            <option value="">Select ...</option>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="addr_province_id">Province</label>
                        <select class="custom-select" name="addr_province_id" id="addr_province_id" required="">
                            <option value="">Select ...</option>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="addr_municipality_id">Municipality/Town</label>
                        <select class="custom-select" name="addr_municipality_id" id="addr_municipality_id" required="">
                            <option value="">Select ...</option>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="addr_barangay_id">Barangay</label>
                        <select class="custom-select" name="addr_barangay_id" id="addr_barangay_id" required="">
                            <option value="">Select ...</option>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name" required="" placeholder="Type here...">
                    </div> 
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control form-control-sm" id="username" name="username" required="" placeholder="Type here...">
                    </div> 
                    <div class="form-group">
                        <label for="password">Temporary Password</label>
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

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css') }}">
<link href="{{ asset('css/components/cards/card.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/elements/avatar.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/elements/miscellaneous.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/elements/tooltip.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/elements/tooltip.js') }}"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        regions();
        $("#addr_region_id").on("change", function (e) {
            var code = e.target.value;
            $.ajax({
                url: "{{ route('address.provinces') }}",
                type: "POST",
                data: {
                    code: code,
                },
                success: function (data) {
                    $("#addr_province_id, #addr_municipality_id, #addr_barangay_id").empty().append('<option value="">Select ...</option>');
                    $.each(data.provinces, function (index, value) {
                        $("#addr_province_id").append('<option value="' + value.province_code + '">' + value.province_description + "</option>");
                    });
                }
            });
        });

        $("#addr_province_id").on("change", function (e) {
            var code = e.target.value;
            $.ajax({
                url: "{{ route('address.city-municipalities') }}",
                type: "POST",
                data: {
                    code: code,
                },
                success: function (data) {
                    $("#addr_municipality_id, #addr_barangay_id").empty().append('<option value="">Select ...</option>');
                    $.each(data.cities_municipalities, function (index, value) {
                        $("#addr_municipality_id").append('<option value="' + value.city_municipality_code + '">' + value.city_municipality_description + "</option>");
                    });
                }
            });
        });

        $("#addr_municipality_id").on("change", function (e) {
            var code = e.target.value;
            $.ajax({
                url: "{{ route('address.barangays') }}",
                type: "POST",
                data: {
                    code: code,
                },
                success: function (data) {
                    $("#addr_barangay_id").empty().append('<option value="">Select ...</option>');
                    $.each(data.barangays, function (index, value) {
                        $("#addr_barangay_id").append('<option value="' + value.barangay_code + '">' + value.barangay_description + "</option>");
                    });
                }
            });
        });

        function regions() {
            $.ajax({
                url: "{{ route('address.regions') }}",
                type: "POST",
                data: {},
                dataType: "json",
                success: function (data) {
                    $("#addr_region_id, #addr_province_id, #addr_municipality_id, #addr_barangay_id").empty().append('<option value="">Select ...</option>');
                    $.each(data.regions, function (index, value) {
                        $("#addr_region_id").append('<option value="' + value.region_code + '">' + value.region_description + "</option>");
                    });
                },
            });
        }

        $('body').on('click', '.create', function() {
            $('#id').val('');
            $('#modalForm').trigger("reset");
            $('#modalTitle').text("Add Branch");
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
                        url: "{{ route('es.account.generate') }}",
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

        $('#input-search').on('keyup', function() {
            var rex = new RegExp($(this).val(), 'i');
            $('.searchable-items .items:not(.items-header-section)').hide();
            $('.searchable-items .items:not(.items-header-section)').filter(function() {
                return rex.test($(this).text());
            }).show();
        });
    });

    if ($("#modalForm").length > 0) {

        $('#modalForm').validate({
            rules: {
                name: "required",
                addr_region_id: "required",
                addr_province_id: "required",
                addr_municipality_id: "required",
                addr_barangay_id: "required",
                username: "required",
                password: "required",
            },
            messages: {
                name: "This field is required",
                addr_region_id: "This field is required",
                addr_province_id: "This field is required",
                addr_municipality_id: "This field is required",
                addr_barangay_id: "This field is required",
                username: "This field is required",
                password: "This field is required",
            },
            errorElement: "div",
            submitHandler: function() {
                $('.submit').attr('disabled', true);
                $.ajax({
                    data: $('#modalForm').serialize(),
                    url: "{{ route('es.branch.store') }}",
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
             
                        if (data.status == 'success') {
                            $('#modalForm').trigger("reset");
                        }

                        Swal.fire({
                            title: data.message, 
                            icon: data.status,
                            confirmButtonText: 'Close'
                        }).then((result) => {  
                            if (result.isConfirmed) {
                                location.reload(); 
                            }
                        });
                    },
                    error: function (data) {
                        $('.submit').attr('disabled', false);
                    }
                });

            }
        });
    }  
</script>

@endpush
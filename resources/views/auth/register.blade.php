@extends('layouts.auth')

@section('content')
    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        <h1 class="">Register account</h1>
                        <p class="signup-link">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group">
                                <label for="type">Register as:</label>
                                <select class="custom-select" name="type" id="type">
                                    <option value="4">Resident</option>
                                    <option value="6">Establishment/Business</option>
                                </select>
                            </div> 
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
                                <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror max-50" maxlength="50" id="name" name="name" required="" placeholder="Type here..." value="{{ old('name') }}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div> 

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control form-control-sm @error('email') is-invalid @enderror max-50" maxlength="50" id="email" name="email" required="" placeholder="Type here..." value="{{ old('email') }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div> 

                            <div class="form-group">
                                <label for="phone_number">Phone Number (09xxxxxxxxx)</label>
                                <input type="text" class="form-control form-control-sm @error('phone_number') is-invalid @enderror max-11" maxlength="11" id="phone_number" name="phone_number" required="" placeholder="Type here..." value="{{ old('phone_number') }}">
                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div> 

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control form-control-sm @error('username') is-invalid @enderror max-50" maxlength="50" id="username" name="username" required="" placeholder="Type here..." value="{{ old('username') }}">
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div> 

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control form-control-sm @error('password') is-invalid @enderror max-50" maxlength="50" id="password" name="password" required="" placeholder="Type here...">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div> 

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control form-control-sm @error('password_confirmation') is-invalid @enderror max-50" maxlength="50" id="password_confirmation" name="password_confirmation" required="" placeholder="Type here...">
                            </div> 
                          
                            <div class="form">
                                <div class="field-wrapper terms_condition">
                                    <div class="n-chk new-checkbox checkbox-outline-primary">
                                        <label class="new-control new-checkbox checkbox-outline-primary">
                                          <input type="checkbox" class="new-control-input" required="">
                                          <span class="new-control-indicator"></span><span>I agree to the <a href="javascript:void(0);">  terms and conditions </a></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper toggle-pass">
                                        <p class="d-inline-block">Show Password</p>
                                        <label class="switch s-primary">
                                            <input type="checkbox" id="toggle-password" class="d-none">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">Register</button>
                                    </div>
                                </div>

                                <div class="field-wrapper text-center keep-logged-in">
                                    <div class="n-chk new-checkbox checkbox-outline-primary">
                                        <label class="new-control new-checkbox checkbox-outline-primary" hidden="">
                                          <input type="checkbox" class="new-control-input" name="remember" id="remember" checked="">
                                          <span class="new-control-indicator"></span>{{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </form>                        
                        @include('auth.credits')

                    </div>                    
                </div>
            </div>
        </div>
        <div class="form-image">
            <div class="l-image">
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('plugins/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>

<script type="text/javascript">
    $(function(){
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


        $('input.max-11').maxlength({
            threshold: 11,
            placement: "right",
        });
        $('input.max-50').maxlength({
            threshold: 50,
            placement: "right",
        });
 
    });    
</script>
@endpush
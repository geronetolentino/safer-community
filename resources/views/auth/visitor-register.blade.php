@extends('layouts.auth')

@section('content')
    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        <h1 class="">Register visitor</h1>
                        <p class="signup-link">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
                        <form method="POST" action="{{ route('register.visitor') }}">
                            @csrf
                            <div class="form-group">
                                <label for="reason">Reason to Visit</label>
                                <select class="custom-select" name="reason" id="reason" required="">
                                    <option value="">Select ...</option>
                                    @foreach($data as $purpose)
                                    <option value="{{ $purpose->id }}">{{ $purpose->purpose_description }}</option>
                                    @endforeach
                                </select>
                            </div> 

                            <div class="form-group">
                                <label for="days_to_stay">Days to Stay in Destination </label>
                                <input type="number" class="form-control form-control-sm @error('days_to_stay') is-invalid @enderror" id="days_to_stay" name="days_to_stay" required="" placeholder="Type here..." value="{{ old('days_to_stay') }}">
                                @error('days_to_stay')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div> 
                            <div class="form-group">
                                <label for="origin_region">Origin Regioin</label>
                                <select class="custom-select" name="origin_region" id="origin_region" required="">
                                    <option value="">Select ...</option>
                                </select>
                            </div> 
                            <div class="form-group">
                                <label for="origin_province">Origin Province</label>
                                <select class="custom-select" name="origin_province" id="origin_province" required="">
                                    <option value="">Select ...</option>
                                </select>
                            </div> 
                            <div class="form-group">
                                <label for="origin_municipality">Origin Municipality/Town</label>
                                <select class="custom-select" name="origin_municipality" id="origin_municipality" required="">
                                    <option value="">Select ...</option>
                                </select>
                            </div> 
                            <div class="form-group">
                                <label for="origin_barangay">Origin Barangay</label>
                                <select class="custom-select" name="origin_barangay" id="origin_barangay" required="">
                                    <option value="">Select ...</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="origin_address">Origin Address</label>
                                <textarea class="form-control form-control-sm @error('origin_address') is-invalid @enderror max-100" maxlength="100" id="origin_address" name="origin_address" placeholder="Type here...">{{ old('origin_address') }}</textarea>
                                @error('origin_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="addr_province_id">Destination Regioin</label>
                                <select class="custom-select" name="addr_region_id" id="addr_region_id" required="">
                                    <option value="">Select ...</option>
                                </select>
                            </div> 
                            <div class="form-group">
                                <label for="addr_province_id">Destination Province</label>
                                <select class="custom-select" name="addr_province_id" id="addr_province_id" required="">
                                    <option value="">Select ...</option>
                                </select>
                            </div> 
                            <div class="form-group">
                                <label for="addr_municipality_id">Destination Municipality/Town</label>
                                <select class="custom-select" name="addr_municipality_id" id="addr_municipality_id" required="">
                                    <option value="">Select ...</option>
                                </select>
                            </div> 
                            <div class="form-group">
                                <label for="addr_barangay_id">Destination Barangay</label>
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

        origin_region();
        function origin_region() {
            $.ajax({
                url: "{{ route('address.regions') }}",
                type: "POST",
                data: {},
                dataType: "json",
                success: function (data) {
                    $("#origin_region, #origin_province, #origin_municipality, #origin_barangay").empty().append('<option value="">Select ...</option>');
             
                    $.each(data.regions, function (index, value) {
                        $("#origin_region").append('<option value="' + value.region_code + '">' + value.region_description + "</option>");
                    });
                },
            });
        }
        $("#origin_region").on("change", function (e) {
            var code = e.target.value;
            $.ajax({
                url: "{{ route('address.provinces') }}",
                type: "POST",
                data: {
                    code: code,
                },
                success: function (data) {
                    $("#origin_province, #origin_municipality, #origin_barangay").empty().append('<option value="">Select ...</option>');
                    $.each(data.provinces, function (index, value) {
                        $("#origin_province").append('<option value="' + value.province_code + '">' + value.province_description + "</option>");
                    });
                }
            });
        });

        $("#origin_province").on("change", function (e) {
            var code = e.target.value;
            $.ajax({
                url: "{{ route('address.city-municipalities') }}",
                type: "POST",
                data: {
                    code: code,
                },
                success: function (data) {
                    $("#origin_municipality, #origin_barangay").empty().append('<option value="">Select ...</option>');
                    $.each(data.cities_municipalities, function (index, value) {
                        $("#origin_municipality").append('<option value="' + value.city_municipality_code + '">' + value.city_municipality_description + "</option>");
                    });
                }
            });
        });

        $("#origin_municipality").on("change", function (e) {
            var code = e.target.value;
            $.ajax({
                url: "{{ route('address.barangays') }}",
                type: "POST",
                data: {
                    code: code,
                },
                success: function (data) {
                    $("#origin_barangay").empty().append('<option value="">Select ...</option>');
                    $.each(data.barangays, function (index, value) {
                        $("#origin_barangay").append('<option value="' + value.barangay_code + '">' + value.barangay_description + "</option>");
                    });
                }
            });
        });

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
                    $("#origin_region, #origin_province, #origin_municipality, #origin_barangay").empty().append('<option value="">Select ...</option>');
                    
                    $("#addr_region_id, #addr_province_id, #addr_municipality_id, #addr_barangay_id").empty().append('<option value="">Select ...</option>');

                    $.each(data.regions, function (index, value) {
                        $("#origin_region").append('<option value="' + value.region_code + '">' + value.region_description + "</option>");
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
        $('input.max-100').maxlength({
            threshold: 100,
            placement: "right",
        });
 
    });   
</script>
@endpush
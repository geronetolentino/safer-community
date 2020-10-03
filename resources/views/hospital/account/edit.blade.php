@extends('layouts.app')
@section('content')

<div class="account-settings-container layout-top-spacing">
    <form method="POST" id="profile-update">
        <div class="account-content">
            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                        <div id="general-info" class="section general-info">
                            <div class="info">
                                <h6 class="">General Information</h6>
                                <div class="row">
                                    <div class="col-lg-11 mx-auto">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-12 col-md-4">
                                                <div class="upload mt-4 pr-md-4">

                                                    <input type="file" class="filepond" name="profile_photo" data-allow-reorder="true"data-max-file-size="1MB" data-max-files="1" accept="image/png, image/jpeg, image/gif">

                                                    {{-- <p class="mt-2">
                                                        <i class="flaticon-cloud-upload mr-1"></i> 
                                                        Upload new profile photo
                                                    </p> --}}
                                                </div>
                                            </div>
                                            <div class="col-xl-9 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                <div class="form">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="name">Name</label>
                                                                <input type="text" class="form-control mb-4" id="name" name="name" placeholder="Full Name" value="{{ Auth::user()->name }}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                        <div id="contact" class="section contact">
                            <div class="info">
                                <h5 class="">ADDRESS and CONTACT INFORMATION</h5>
                                <div class="row">
                                    <div class="col-md-11 mx-auto">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="addr_province_id">Province</label>
                                                    <select class="form-control" name="addr_province_id" id="addr_province_id" required="">
                                                        <option value="1">Pangasinan</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="addr_municipality_id">Municipality/Town</label>
                                                    <select class="form-control" name="addr_municipality_id" id="addr_municipality_id" required="">
                                                        <option value="">Select ...</option>
                                                        @foreach($municipalities as $municipality)
                                                        <option value="{{ $municipality->id }}" {{ Auth::user()->addr_municipality_id == $municipality->id?'selected':'' }}>
                                                            {{ $municipality->municipality }} 
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="addr_barangay_id">Barangay</label>
                                                    <select class="form-control" name="addr_barangay_id" id="addr_barangay_id" required="">
                                                        <option value="">Select ...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="address">Address</label>
                                                    <input type="text" class="form-control" id="address" name="address" placeholder="Street name / Zone # / House #" value="{{ Auth::user()->address }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="phone_number">Phone</label>
                                                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Write your phone number here" value="{{ Auth::user()->info->phone_number }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Write your email here" value="{{ Auth::user()->email }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="account-settings-footer">
            <div class="as-footer-container">
                <a href="{{ route('account') }}" class="btn btn-dark">Cancel</a>
                <div class="blockui-growl-message">
                    <i class="flaticon-double-check"></i>&nbsp; Settings Saved Successfully
                </div>
                <button type="submit" class="btn btn-primary submit">Save Changes</button>
            </div>
        </div>
    </form>
</div>

@endsection

@push('styles')
<link href="{{ asset('plugins/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/users/account-setting.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css">
<link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.min.css">
<style lang="scss">
    .filepond--root[data-style-panel-layout~="compact circle"] {
        border-radius: 99999rem !important;
        overflow: hidden !important;
        width: 150 !important;
    }
    .swal-footer {
        text-align: center;
    }
</style>
<style lang="scss">
    .filepond--root .filepond--drop-label {
      height: 318px;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<script type="text/javascript">
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        selectMunicipality();

        $("#addr_municipality_id").change(function(){
            selectMunicipality();
        });    

        function selectMunicipality(id = $('#addr_municipality_id').val()){
            var barangay_id = {{ Auth::user()->addr_barangay_id }}
            var barangays = @json($barangays);
            var barangay_dp = $('#addr_barangay_id');

            barangay_dp.empty();
            barangay_dp.append(new Option('Select ...',''));
            barangays.forEach(function(e) {
                if (id == e.addr_municipality_id) {
                    console.log(id);
                    //barangay_dp.append(new Option(e.barangay, e.id));
                    var br = barangay_id==e.id?'selected':'';
                    barangay_dp.append('<option value="'+e.id+'"'+br+'>'+e.barangay+'</option>'); 
                }
            });

        }

        $("#profile-update").validate({
            rules: {
                name: "required",
                day: "required",
                month: "required",
                year: "required",
                addr_province_id: "required",
                addr_municipality_id: "required",
                addr_barangay_id: "required",
                address: "required",
                phone_number: "required",
                email: "required",
            },
            messages: {
                name: "This field is required",
                day: "This field is required",
                month: "This field is required",
                year: "This field is required",
                addr_province_id: "This field is required",
                addr_municipality_id: "This field is required",
                addr_barangay_id: "This field is required",
                address: "This field is required",
                phone_number: "This field is required",
                email: "This field is required",
            },
            errorElement: "div",
            submitHandler: function () {
                $(".submit").attr("disabled", true);

                $.ajax({
                    data: $("#profile-update").serialize(),
                    url: "{{ route('hp.account.save') }}",
                    type: "POST",
                    dataType: "json",
                    success: function (data) {

                        $(".submit").attr("disabled", false);
                        Swal.fire({
                            title: "Profile updated.", 
                            icon: "success",
                            confirmButtonText: 'Close'
                        });
                    },
                    error: function (data) {
                        console.log("Error:", data);
                        $(".submit").attr("disabled", false);
                    },
                });
            },
        });
    });    

    FilePond.registerPlugin(
        // encodes the file as base64 data
        FilePondPluginFileEncode,
        
        // validates the size of the file
        FilePondPluginFileValidateSize, 

        // validates files based on input type
        FilePondPluginFileValidateType,
        
        // corrects mobile image orientation
        FilePondPluginImageExifOrientation,
        
        // previews dropped images
        FilePondPluginImagePreview,
    
        // resizes the image to fit a certain size
        FilePondPluginImageResize,
    
        // crops the image to a certain aspect ratio
        FilePondPluginImageCrop,
    
        // applies crop and resize information on the client
        FilePondPluginImageTransform
    );

    FilePond.setOptions({
        server: {
            process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                const formData = new FormData();
                formData.append(fieldName, file, file.name);

                const request = new XMLHttpRequest();
                request.open('POST', '{{ route('hp.account.photo') }}');
                request.setRequestHeader('X-CSRF-TOKEN' , $('meta[name="csrf-token"]').attr('content'));

                request.upload.onprogress = (e) => {
                    progress(e.lengthComputable, e.loaded, e.total);
                };

                request.onload = function() {
                    if (request.status >= 200 && request.status < 300) {
                        load(request.responseText);
                    }
                    else {
                        error('oh no');
                    }
                };

                request.send(formData);
            }
        }
    });
    FilePond.create(
        document.querySelector('input[name="profile_photo"]'),
        {
            labelIdle: `Drag & Drop your new profile photo or <span class="filepond--label-action">Browse</span>`,
        }
    ); 
</script>
@endpush
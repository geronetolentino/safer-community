@extends('layouts.app')

@section('content')

<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            @if($scanner->status == 0) 
            <div class="alert alert-arrow-right alert-icon-right alert-light-danger mb-4" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12" y2="16"></line>
                </svg>
                <strong>Oops!</strong> QR code scanner is offline. 
            </div>
            @else
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <div id="qr-reader"></div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <h1>{{ $access->establishment->name }}</h1>
                    <h4>Last Scan Result: <b><span id="lsr"></span></b></h4>
                    
                    <table class="table table-hover">
                        <tr>
                            <td>POI #: </td>
                            <td><b><span id="poi_id"></span></b></td>
                        </tr>
                        <tr>
                            <td>Current Status: </td>
                            <td><b><span id="current_status"></span></b></td>
                        </tr>
                        <tr>
                            <td>Under Quarantine: </td>
                            <td><b><span id="quarantine_period"></span></b></td>
                        </tr>
                        <tr>
                            <td>Remarks: </td>
                            <td><b><span id="remarks"></span></b></td>
                        </tr>
                    </table>
                </div>
            </div>           
            @endif
        </div>
    </div>
</div>

@endsection

@push('styles')
<style type="text/css">
    .table > tbody > tr > td {
        font-size: 18px !important;
    }
    .w-40 {
        width: 40%;
    }
    a#qr-reader__dashboard_section_swaplink {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/html5-qrcode.js') }}"></script>
<script src="{{ asset('js/beep.js') }}"></script>
<script>

    function beep(keys) {
        var key = keys.shift();
        if(typeof key == 'undefined') return; // song ended
        new Beep(22050).play(key[0], key[1], [Beep.utils.amplify(8000)], function() { beep(keys); });
    }

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').on('click', function() {
            $('a#qr-reader__dashboard_section_swaplink').hide();
        });

    });

    var lastResult, countResults = 0;

    function onScanSuccess(qrCodeMessage) {
        if (qrCodeMessage !== lastResult) {
            beep([[2000, 0.1]]);
            ++countResults;
            lastResult = qrCodeMessage;

            Swal.fire({
                title: "POI #: "+qrCodeMessage,
                text: "Scanner Result",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                buttonsStyling: true
            }).then((result) => {  
                if (result.isConfirmed) {
                    sendQr(qrCodeMessage);
                }
            });
        }

		setTimeout(function(){
			lastResult = null;
		},5000);
    }

    function onScanError(errorMessage) {
        Swal.fire({
            title: 'Oops!',
            text: 'An error occured. Please try again later.',
            icon: 'danger'
        });
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", { 
            fps: 8, 
            qrbox: 250,
            aspectRatio: 1.777778
        });
    html5QrcodeScanner.render(onScanSuccess);

    function sendQr(qr) {
        var scanner = "{{ $scanner->uid }}";    

        $.ajax({
            method: "POST",
            url: "{{ route('rs.scanner.register') }}",
            data: { qr: qr, scanner: scanner },
            dataType: "json",
            success: function(data) {

                var span_poi = $('span#poi_id');
                var span_current_status = $('span#current_status');
                var span_quarantine_period = $('span#quarantine_period');
                var span_remarks = $('span#remarks');
                var span_lsr = $('span#lsr');

                var current_status = 'No record.';
                var quarantine_period = 'No record.';
                var remarks = 'Enter with caution.';

                if (data['health']) {

                    current_status = data['health']['current_status'];
                    quarantine_period = data['health']['quarantine_period'];
                    remarks = data['remarks'];

                } 

                if (current_status == 'Covid-19 Positive') {
                    beep([[3000, 0.5], [3000, 0.5], [3000, 0.5], [3000, 0.5], [3000, 0.5]]);
                    textColor = 'text-danger';
                    Swal.fire({
                        title: 'SUSPECTED COVID-19 POSITIVE!',
                        text: 'DO NOT ALLOW TO ENTER!',
                        icon: 'error',
                    });
                } else if (current_status == 'PUM' || current_status == 'PUI') { 
                    beep([[3000, 0.5], [3000, 0.5], [3000, 0.5]]);
                    textColor = 'text-warning';
                    Swal.fire({
                        title: 'WARNING!',
                        icon: 'warning',
                    });
                } else if (current_status == 'Covid-19 Negative') { 
                    textColor = 'text-success';
                    beep([[3000, 0.5]]);
                    Swal.fire({
                        title: 'Safe to roam/travel!',
                        icon: 'success',
                    });
                } else { 
                    textColor = 'text-warning';
                    beep([[3000, 0.5]]);
                    Swal.fire({
                        title: 'WARNING!',
                        icon: 'warning',
                    });
                }
                
                span_poi.removeAttr('class').addClass(textColor).text(data['poi']);
                span_current_status.removeAttr('class').addClass(textColor).text(current_status);
                span_quarantine_period.removeAttr('class').addClass(textColor).text(quarantine_period);
                span_remarks.removeAttr('class').addClass(textColor).text(remarks);
                span_lsr.removeAttr('class').text(data['entry']);
                
            },
        }).done(function() {
            $( this ).addClass( "done" );
        });
    }

</script>
@endpush
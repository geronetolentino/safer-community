@extends('layouts.app')

@section('content')

<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <div id="qr-reader"></div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <h4>Last Scan Result: <b><span class="lsr"></span></b></h4>
                    
                    <table class="table table-hover">
                        <tr>
                            <td>POI #: </td>
                            <td><b><span class="poi_id"></span></b></td>
                        </tr>
                        <tr>
                            <td>Current Status: </td>
                            <td><b><span class="current_status"></span></b></td>
                        </tr>
                        <tr>
                            <td>Under Quarantine: </td>
                            <td><b><span class="quarantine_period"></span></b></td>
                        </tr>
                        <tr>
                            <td>Remarks: </td>
                            <td><b><span class="remarks"></span></b></td>
                        </tr>
                    </table>
                </div>
            </div>           

        </div>
    </div>
</div>

@endsection

@push('styles')
<style type="text/css">
    .table > tbody > tr > td {
        font-size: 20px !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
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
        
        $.ajax({
            method: "GET",
            url: "{{ env('APP_URL') }}es/visit/scanner/{{ $est_code}}/"+qr+"/",
            contentType: "application/json",
            dataType: "json",
            success: function(data) {

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
                    Swal.fire({
                        title: 'SUSPECTED COVID-19 POSITIVE!',
                        text: '',
                        icon: 'danger',
                    });
                } else if (current_status == 'PUM' || current_status == 'PUI') { 
                    beep([[3000, 0.5], [3000, 0.5], [3000, 0.5]]);
                    Swal.fire({
                        title: 'WARNING!',
                        icon: 'warning',
                    });
                } else { 
                    beep([[3000, 0.5]]);
                    Swal.fire({
                        title: 'WARNING!',
                        icon: 'warning',
                    });
                }
                
                $('span.poi_id').text(data['poi']);
                $('span.current_status').text(current_status);
                $('span.quarantine_period').text(quarantine_period);
                $('span.remarks').text(remarks);
                $('span.lsr').text(data['entry']);
                
            },
        }).done(function() {
            $( this ).addClass( "done" );
        });
    }

</script>
@endpush
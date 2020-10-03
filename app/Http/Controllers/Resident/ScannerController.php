<?php

namespace App\Http\Controllers\Resident;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Response;
use Carbon\Carbon;

use App\Models\User;
use App\Models\UserInfo;
use App\Models\Scanner;
use App\Models\HealthData;
use App\Models\Establishment;
use App\Models\EstablishmentEmployee;
use App\Models\EstablishmentVisitorLog;
use App\Models\EstablishmentScannerAccess;

class ScannerController extends Controller
{
    public function index($uid)
    {
        $scanner = Scanner::findByUid($uid)->first();
        if (!$scanner) 
            abort(404);

        $access = EstablishmentScannerAccess::findByScanner($scanner->id)->first();
        if (!$access) 
            abort(404);

        $data = [
            'pageName' => 'QR Scanner',
            'navName' => 'Dashboard',
            'scanner' => $scanner,
            'access' => $access,
        ];

        return view('resident.scanner.reader')->with($data);
    }

    public function register(Request $request)
    {
        $poi_id = $request->qr;
        $uid = $request->scanner;

        $scanner = Scanner::findByUid($uid)->first();
        $access = EstablishmentScannerAccess::findByScanner($scanner->id)->first();
        $est_code = $access->establishment->est_code;

        $poi = UserInfo::where('poi_id', $poi_id)->first();

        if ($poi) {

            $health = HealthData::poi($poi_id)->first();

            $check = EstablishmentVisitorLog::poi($poi_id)
            ->estcode($est_code)
            ->cstatus('IN')
            ->today()
            ->first();

            if ($check) {

                $entry = 'OUT';
                $check->status = $entry;
                $check->checkout = Carbon::now();
                $check->save();

            } else {

                $entry = 'IN';

                if ($health ) {
                    if ($health->current_status == 'Covid-19 Positive' || $health->current_status == 'PUI' || $health->current_status == 'PUM') {
                        $entry = 'ATTEMPT';
                    }
                }
               
                EstablishmentVisitorLog::create([
                    'poi_id' => $poi_id,
                    'scanner_id' => $scanner->id,
                    'est_code' => $est_code,
                    'checkin' => Carbon::now(),
                    'checkout' => null,
                    'status' => $entry,
                ]);
            }
            
            if ($health) {

                $hdata = [
                    'current_status' => $health->current_status,
                    'quarantine_period' => $health->quarantine_period>0?'Person is under quarantine':'NO',
                ];

                if ($health->current_status == 'Covid-19 Positive') {

                    $remarks = 'SYSTEM DETECTED - COVID-19 POSITIVE';

                } else if ($health->current_status == 'Covid-19 Negative') {

                    $remarks = 'Safe to roam/travel';

                } else if ($health->current_status == 'PUI' || $health->current_status == 'PUM') {

                    $remarks = 'Person is tagged as '.$health->current_status.'. Not allowed to go anywhere.';

                }

            } else {

                $hdata = null;
                $remarks = 'Enter with caution.';

            }

            $data = [
                'poi' => $poi_id,
                'health' => $hdata?$hdata:null,
                'remarks' => $remarks,
                'entry' => $entry,
            ];

        } else {

            $data = [
                'poi' => 'INVALID / UNKNOWN POI NUMBER',
                'health' => null,
                'remarks' => 'INVALID / UNKNOWN POI NUMBER',
                'entry' => null,
            ];
            
        }

        return Response::json($data);
    }
}
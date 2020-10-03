<?php

namespace App\Http\Controllers\Establishment\Branch;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Response;
use Carbon\Carbon;

use App\Models\Notification;
use App\Models\Establishment;
use App\Models\EstablishmentVisitorLog;
use App\Models\UserInfo;
use App\Models\HealthData;

class VisitorController extends Controller
{
    public function index($est_code)
    {
        $branch = Establishment::findByEc($est_code);

        if (!$branch)
            return redirect()->route('es.branch');

        $data = [
            'pageName' => 'View Branch ['.$branch->name.']',
            'navName' => 'Branches',
            'branch' => $branch,
        ];

        return view('establishment.branch.single.visitor-log')->with($data);
    }

    public function list($est_code)
    {
        $data = EstablishmentVisitorLog::estcode($est_code)->get();

        return datatables()->of($data)
            ->addColumn('visitor', function($data){
                return '<b>POI: '.$data->person->poi_id.'</b>';
            })
            ->addColumn('date', function($data){

                $in = Carbon::parse($data->checkin)->format('M d Y - g:i A');

                if ($data->status == 'ATTEMPT') {

                    return $data->status .': '.$in;

                } else {

                    if ($data->status == 'OUT') {

                        $out = Carbon::parse($data->checkout)->format('M d Y - g:i A');

                    } else {

                        $out = null;

                    }

                    return 'IN: '.$in.'<br>OUT: '.$out;
                }
            })
            ->addColumn('status', function($data){
                return $data->status.'<br><small class="text-warning">'.$data->isAutoOut.'</small>';
            })
            ->addColumn('action', function($data){
                return '<a href="" class="btn btn-outline-primary btn-sm">Send Alert</a>';
            })
            ->rawColumns(['visitor','date','status','action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function register($est_code, $poi_id)
    {
        $entry = false;
        $poi = UserInfo::where('poi_id', $poi_id)->first();
        $health = HealthData::poi($poi_id)->first();

        if ($poi) {

            $entry = 'failed';

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

                if ($health && $health->current_status == 'Covid-19 Positive' || $health->current_status == 'PUI' || $health->current_status == 'PUM') {
                        $entry = 'ATTEMPT';
                }

                EstablishmentVisitorLog::create([
                    'poi_id' => $poi_id,
                    'scanner_id' => 0,
                    'est_code' => $est_code,
                    'checkin' => Carbon::now(),
                    'checkout' => null,
                    'status' => $entry,
                ]);
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
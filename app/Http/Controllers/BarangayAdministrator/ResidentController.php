<?php

namespace App\Http\Controllers\BarangayAdministrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Response;
use Carbon\Carbon;

use App\Models\User;
use App\Models\HealthData;
use App\Models\HealthDataSetterLog;

class ResidentController extends Controller
{
    public function index()
    {
        $data = [
            'pageName' => 'Residents',
            'navName' => 'Residents',
        ];

        return view('barangay-admin.resident.index')->with($data);
    }

    public function list()
    {
    	$data = User::residentOf(['addr_barangay_id', Auth::user()->addr_barangay_id])->get();

        return datatables()->of($data)
        ->addColumn('resident', function($data){
            return 'POI #: <strong>'.$data->info->poi_id.'</strong>';
        })
        ->addColumn('documents', function($data){
            return $data->documents->count();
        })
        ->addColumn('health_status', function($data){
            if ($data->healthData) {
                if ($data->healthData->current_status == 'Covid-19 Positive') {
                    return '<span class="text-warning">Covid19 Positive</span>';
                }
                    
                return '<span class="">'.$data->healthData->current_status.'</span>';
            } else {
                return '<span class="">No record</span>';
            }
        })
        ->addColumn('action', function($data){
            if ($data->healthData && $data->healthData->current_status == 'PUM') {
                $days = $data->healthData->created_at->diff(Carbon::now())->days;
                return (14 - $days) .' day(s) left';
            }

            return '<button class="btn btn-outline-primary btn-sm set-health-status" data-id="'.$data->info->poi_id.'">Set Health Status</button>';
        })
        ->rawColumns(['resident','documents','health_status','action'])
        ->addIndexColumn()
        ->make(true);
    }

    public function setHealthStatus(Request $request)
    {
        $poi_id = $request->id;
        $status = $request->status;

        $healthData = HealthData::poi($poi_id)->first();

        if ($healthData) {
            if (!$healthData->hci_locked) {

                $healthData->current_status = 'PUM';
                $healthData->quarantine_period = 14;
                $healthData->set_by = Auth::user()->id;
                $healthData->hci_locked = FALSE;
                $healthData->save();

                HealthDataSetterLog::create([
                    'setter_id' => Auth::user()->id,
                    'source' => 'HealthData',
                    'source_id' => $healthData->id
                ]);

                $response = [
                    'status' => 'success',
                    'message' => 'POI has been tagged as PUM'
                ];

            } else {

                $response = [
                    'status' => 'danger',
                    'message' => 'POI health status was locked by HCI.'
                ];

            }
        } else {

            HealthData::create([
                'poi_id' => $poi_id,
                'current_status' => 'PUM',
                'quarantine_period' => 14,
                'set_by' => Auth::user()->id,
                'hci_locked' => FALSE
            ]);

            $response = [
                'status' => 'success',
                'message' => 'POI has been tagged as PUM'
            ];
        }

        return Response::json($response);
    }


}
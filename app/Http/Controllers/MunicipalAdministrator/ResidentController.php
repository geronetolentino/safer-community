<?php

namespace App\Http\Controllers\MunicipalAdministrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Response;
use Carbon\Carbon;

use App\Models\User;
use App\Models\UserInfo;
use App\Models\EstablishmentVisitorLog;
use App\Models\AccessLog;

use App\Traits\NotificationTrait;

class ResidentController extends Controller
{
    use NotificationTrait; 

    public function index()
    {
        $data = [
            'pageName' => 'Residents',
            'navName' => 'Residents',
        ];

        return view('municipal-admin.resident.index')->with($data);
    }

    public function list()
    {
    	$data = User::residentOf(['addr_municipality_id', Auth::user()->addr_municipality_id])->get();

        return datatables()->of($data)
            ->addColumn('resident', function($data){
                return 'POI #: <strong>'.$data->info->poi_id.'</strong>';
            })
            ->addColumn('documents', function($data){
                return $data->documents->count();
            })
            ->addColumn('barangay', function($data){
                return $data->barangay->barangay_description;
            })
            ->addColumn('health_status', function($data){
                if ($data->healthData) {
                    if ($data->healthData->current_status == 'Covid-19 Positive') {
                        $status = '<span class="text-warning">Covid19 Positive</span>';
                    }
                        
                    $status = '<span class="">'.$data->healthData->current_status.'</span>';
                } else {
                    $status = '<span class="">No record</span>';
                }

                $label = 'Set Health Status';
                if ($data->healthData && $data->healthData->current_status == 'PUM') {
                    $days = $data->healthData->created_at->diff(Carbon::now())->days;
                    $label = (14 - $days) .' day(s) left';
                }

                $button = '<button class="btn btn-outline-primary btn-sm float-right set-health-status" data-id="'.$data->info->poi_id.'">'.$label.'</button>';

                return $status . $button;
            })
            ->addColumn('action', function($data){

                return '<a href="'.route('ma.resident.establishment.log',['poi'=>$data->info->poi_id]).'" class="btn btn-outline-primary btn-sm">Establishment Log</a>';
            })
            ->rawColumns(['resident','documents','barangay','health_status','action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function establishmentLog($poi)
    {   

        AccessLog::create([
            'accessor_id' => Auth::user()->id,
            'data_owner_id' => $poi,
            'data_owner_approved' => false,
            'information' => 'ESTABLISHMENT LOG',
            'is_accessed' => true,
        ]);

        $data = [
            'pageName' => 'Resident Establishment Logs',
            'navName' => 'Residents',
            'logs' => EstablishmentVisitorLog::poi($poi)->get(),
            'info' => UserInfo::poi($poi)->first(),
            'accessLogs' => AccessLog::findByAccessor(Auth::user()->id)->findByPoi($poi)->get()
        ];

        return view('municipal-admin.resident.establishment-log')->with($data);
    }

    public function setHealthStatus(Request $request)
    {
        $poi_id = $request->id;
        $status = $request->status;

        $healthData = HealthData::poi($poi_id)->first();

        if ($healthData) {
            if (!$healthData->hci_locked) {

                $healthData->current_status = $status;
                $healthData->quarantine_period = 14;
                $healthData->set_by = Auth::user()->id;
                $healthData->hci_locked = FALSE;
                $healthData->save();

                HealthDataSetterLog::create([
                    'setter_id' => Auth::user()->id,
                    'source' => 'HealthData',
                    'source_id' => $healthData->id
                ]);

                $this->notificationPush([
                    [
                        'user_id' => $patient->user->id,
                        'title' => 'Health Status Update',
                        'message' => 'LGU updated your health status [<strong>'.$current_status.'</strong>].',
                        'seen' => 0
                    ]
                ]);

                $response = [
                    'status' => 'success',
                    'message' => 'POI has been tagged as '.$status
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
                'current_status' => $status,
                'quarantine_period' => 14,
                'set_by' => Auth::user()->id,
                'hci_locked' => FALSE
            ]);

            $this->notificationPush([
                [
                    'user_id' => $patient->user->id,
                    'title' => 'Health Status Update',
                    'message' => 'LGU updated your health status [<strong>'.$current_status.'</strong>].',
                    'seen' => 0
                ]
            ]);

            $response = [
                'status' => 'success',
                'message' => 'POI has been tagged as '.$status
            ];
        }

        return Response::json($response);
    }


}
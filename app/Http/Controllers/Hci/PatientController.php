<?php

namespace App\Http\Controllers\Hospital;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Response;
use Carbon\Carbon;

use App\Models\User;
use App\Models\UserInfo;
use App\Models\HealthData;
use App\Models\HealthTest;
use App\Models\Notification;
use App\Models\HospitalPatient;
use App\Models\HealthDataSetterLog;

use App\Traits\NotificationTrait;

class PatientController extends Controller
{
    use NotificationTrait; 

    public function index()
    {
        $data = [
            'pageName' => 'Patients',
            'navName' => 'Patient',
            'residents' => User::residents()->get(),
        ];

        return view('hospital.patient.index')->with($data);
    }

    public function list()
    {
    	$data = HospitalPatient::hci(Auth::user()->hospital->id)->get();

        return datatables()->of($data)
            ->addColumn('patient', function($data){
                return $data->resident->poi_id;
            })
            ->addColumn('status', function($data){
                return $data->patient_status;
            })
            ->addColumn('action', function($data){
                return '<a href="'.route('hp.patient.single',['poi_id'=>$data->resident->poi_id]).'" class="btn btn-outline-primary btn-sm">Health Data</a>';
            })
            ->rawColumns(['patient','status','action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function add(Request $request)
    {

        $patient = HospitalPatient::firstOrCreate(
            [
                'poi_id' => $request->id,
                'patient_status' => 'ADMIT',
                'discharge_date' => null,
            ],
            [
                'hospital_id' => Auth::user()->hospital->id,
                'admit_date' => Carbon::now(),
            ]
        );

        if ($patient->wasRecentlyCreated) { 

            $response['status'] = 'success';
            $response['message'] = 'POI added to patient list.';

        } else {

            $response['status'] = 'warning';
            $response['message'] = 'Unable to add POI to patient list.';

        }
        
        return Response::json($response);
    }

    public function single($poi_id) 
    {
        $poi = UserInfo::poi($poi_id)->first();

        if (!$poi) {
            abort(404);
        }

        $data = [
            'pageName' => 'Patient Health Data',
            'navName' => 'Patient',
            'patient' => HospitalPatient::findByPoi($poi_id),
        ];

        return view('hospital.patient.single.index')->with($data);
    }

    public function setHealthStatus(Request $request)
    {
        $poi_id = $request->id;
        $current_status = $request->current_status;
        $quarantine_period = $request->quarantine_period;

        $patient = UserInfo::poi($poi_id)->first();

        if ($patient) {

            $municipality = $patient->user->municipality->user_id??null;
            $barangay = $patient->user->barangay->user_id??null;

            $healthData = HealthData::poi($poi_id)->first();

            if ($healthData) {

                if ($healthData->hci_locked == Auth::user()->id) {

                    $healthData->current_status = $current_status;
                    $healthData->quarantine_period = $quarantine_period;
                    $healthData->set_by = Auth::user()->id;
                    $healthData->hci_locked = Auth::user()->id;
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
                            'message' => 'A health care institution updated your health status [<strong>'.$current_status.'</strong>].',
                            'seen' => 0
                        ],
                        [
                            'user_id' => $municipality,
                            'title' => 'POI Health Status Update',
                            'message' => 'A health care institution updated your resident [ POI #:<strong>'. $poi_id .'</strong>] health status [<strong>'.$current_status.'</strong>].',
                            'seen' => 0
                        ],
                        [
                            'user_id' => $barangay,
                            'title' => 'POI Health Status Update',
                            'message' => 'A health care institution updated your resident [ POI #:<strong>'. $poi_id .'</strong>] health status [<strong>'.$current_status.'</strong>].',
                            'seen' => 0
                        ]
                    ]);

                    $response = [
                        'status' => 'success',
                        'message' => 'POI has been tagged as '.$current_status
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
                    'current_status' => $current_status,
                    'quarantine_period' => $quarantine_period,
                    'set_by' => Auth::user()->id,
                    'hci_locked' => Auth::user()->id
                ]);

                $this->notificationPush([
                    [
                         'user_id' => $patient->user->id,
                        'title' => 'Health Status Update',
                        'message' => 'A health care institution updated your health status [<strong>'.$current_status.'</strong>].',
                        'seen' => 0
                    ],
                    [
                        'user_id' => $municipality,
                        'title' => 'POI Health Status Update',
                        'message' => 'A health care institution updated your resident [ POI #:<strong>'. $poi_id .'</strong>] health status [<strong>'.$current_status.'</strong>].',
                        'seen' => 0
                    ],
                    [
                        'user_id' => $barangay,
                        'title' => 'POI Health Status Update',
                        'message' => 'A health care institution updated your resident [ POI #:<strong>'. $poi_id .'</strong>] health status [<strong>'.$current_status.'</strong>].',
                        'seen' => 0
                    ]
                ]);

                $response = [
                    'status' => 'success',
                    'message' => 'POI has been tagged as '.$current_status
                ];
            }

        } else {

            $response = [
                'status' => 'warning',
                'message' => 'INVALID / UNKNOWN POI NUMBER'
            ];
        }

        return Response::json($response);
    }
}
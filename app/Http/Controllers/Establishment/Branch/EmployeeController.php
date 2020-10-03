<?php

namespace App\Http\Controllers\Establishment\Branch;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Response;

use App\Models\Visit;
use App\Models\People;
use App\Models\UserInfo;
use App\Models\AccessLog;
use App\Models\Establishment;
use App\Models\EstablishmentEmployee;
use App\Models\EstablishmentVisitorLog;
use App\Models\EstablishmentScannerAccess;

class EmployeeController extends Controller
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
            'employees' => People::establishment(Auth::user()->id)->approved()->whereDoesntHave('deployedBranch')->get()
        ];

        return view('establishment.branch.single.employee')->with($data);
    }

	public function list($est_code)
	{
        $establishment = Establishment::findByEc($est_code);
        $data = EstablishmentEmployee::findByEstId($establishment->id)->get();

        return datatables()->of($data)
            ->addColumn('employee', function($data){
                return '<b>'.$data->resident->name.'</b><br>'.$data->resident->info->poi_id;
            })
            ->addColumn('address', function($data){
                return $data->resident->fullAddress;
            })
            ->addColumn('health_status', function ($data) {
                if ($data->resident->healthData) {
                    if ($data->healthData->current_status == 'Covid-19 Positive') {
                        return '<span class="text-warning">Covid-19 Positive</span>';
                    }
                        
                    return '<span class="">'.$data->healthData->current_status.'</span>';
                } else {
                    return '<span class="">No record</span>';
                }
            })
            ->addColumn('action', function($data){
                return '<button class="btn btn-sm btn-primary undeploy" data-id="'.$data->resident->id.'">Undeploy</button>';
            })
            ->rawColumns(['employee','address','health_status','action'])
            ->addIndexColumn()
            ->make(true);
	}

    public function deploy(Request $request, $est_code)
    {
        $status = $request->status;
        $id = $request->id;

        $branch = Establishment::findByEc($est_code);
        $deployed = EstablishmentEmployee::user($id)->first();

        if ($status == 'deploy') {

            if ($deployed) {

                $response['status'] = 'warning';
                $response['message'] = 'Employee already deployed.';

            } else {

                EstablishmentEmployee::create([
                    'establishment_id' => $branch->id,
                    'user_id' => $id,
                    'status' => 1
                ]);

                $response['status'] = 'success';
                $response['message'] = 'Employee successfully deployed.';
            }

        } else {

            $employee = EstablishmentEmployee::user($id)->first();

            EstablishmentScannerAccess::findByEmployee($employee->id)->first()->delete();

            $employee->delete();

            $response['status'] = 'success';
            $response['message'] = 'Employee successfully undeploy.';
            
        }

        return Response::json($response);
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
            'pageName' => 'Employee Establishment Logs',
            'navName' => 'Branches',
            'logs' => EstablishmentVisitorLog::poi($poi)->get(),
            'info' => UserInfo::poi($poi)->first(),
            'accessLogs' => AccessLog::findByAccessor(Auth::user()->id)->findByPoi($poi)->get()
        ];

        return view('establishment.employee.establishment-log')->with($data);
    }

    // public function branchList($id)
    // {
    //     return $this->empDtt($id);
    // }

    // private function empDtt($id)
    // {

    //     $data = EstablishmentEmployee::findByEstId($id)->approved()->get();

    //     return datatables()->of($data)
    //         ->addColumn('employee', function($data){
    //             return '<b>POI: '.$data->resident->name.'</b><br>'.$data->resident->info->poi_id;
    //         })
    //         ->addColumn('address', function($data){
    //             return $data->resident->fullAddress;
    //         })
    //         ->addColumn('health_status', function ($data) {
    //             if ($data->healthData) {
    //                 if ($data->healthData->current_status == 'Covid-19 Positive') {
    //                     return '<span class="text-warning">Covid19 Positive</span>';
    //                 }
                        
    //                 return '<span class="">'.$data->healthData->current_status.'</span>';
    //             } else {
    //                 return '<span class="">No record</span>';
    //             }
    //         })
    //         ->addColumn('action', function($data){
    //             return '<a href="'.route('es.employee.establishment.log',['poi'=>$data->resident->info->poi_id]).'" class="btn btn-outline-primary btn-sm">Establisgment Log</a>';
    //         })
    //         ->rawColumns(['employee','address','health_status','action'])
    //         ->addIndexColumn()
    //         ->make(true);
    // }

    // public function enrollStatus(Request $request)
    // {

    //     $status = $request->status;
    //     $eeid = $request->eeid;

    //     $employee = People::find($eeid);

    //     $response['status'] = 'success';

    //     if ($status == 0) {
    //         $employee->delete();
    //         $response['message'] = 'Request has been deleted.';
    //     } else {
    //         $employee->status = $status;
    //         $employee->save();
    //         $response['message'] = 'Request has been approved.';
    //     }

    //     return Response::json($response);
    // }

}
<?php

namespace App\Http\Controllers\Establishment;

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

class EmployeeController extends Controller
{
    public function index()
    {

        $data = [
            'pageName' => 'Employees',
            'navName' => 'Employees',
            'pendingEmployees' => People::establishment(Auth::user()->id)->pending()->get()
        ];

        return view('establishment.employee.index')->with($data);
    }

	public function list()
	{
        $data = People::establishment(Auth::user()->id)->approved()->get();

        return datatables()->of($data)
            ->addColumn('employee', function($data){
                return '<b>'.$data->resident->name.'</b><br>'.$data->resident->info->poi_id;
            })
            ->addColumn('address', function($data){
                return $data->resident->fullAddress;
            })
            ->addColumn('health_status', function ($data) {
                if ($data->resident->healthData) {

                    if ($data->resident->healthData->current_status == 'Covid-19 Positive') {
                        return '<span class="text-warning">Covid-19 Positive</span>';
                    }
                        
                    return '<span>'.$data->resident->healthData->current_status.'</span>';
                } else {
                    return '<span>No record</span>';
                }
            })
            ->addColumn('action', function($data){
                return '<a href="'.route('es.employee.establishment.log',['poi'=>$data->resident->info->poi_id]).'" class="btn btn-outline-primary btn-sm">Establishment Log</a>';
            })
            ->rawColumns(['employee','address','health_status','action'])
            ->addIndexColumn()
            ->make(true);
	}

    public function branchList($id)
    {
        return $this->empDtt($id);
    }

    private function empDtt($id)
    {

        $data = EstablishmentEmployee::findByEstId($id)->approved()->get();

        return datatables()->of($data)
            ->addColumn('employee', function($data){
                return '<b>POI: '.$data->resident->name.'</b><br>'.$data->resident->info->poi_id;
            })
            ->addColumn('address', function($data){
                return $data->resident->fullAddress;
            })
            ->addColumn('health_status', function ($data) {
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
                return '<a href="'.route('es.employee.establishment.log',['poi'=>$data->resident->info->poi_id]).'" class="btn btn-outline-primary btn-sm">Establishment Log</a>';
            })
            ->rawColumns(['employee','address','health_status','action'])
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
            'pageName' => 'Employee Establishment Logs',
            'navName' => 'Branches',
            'logs' => EstablishmentVisitorLog::poi($poi)->get(),
            'info' => UserInfo::poi($poi)->first(),
            'accessLogs' => AccessLog::findByAccessor(Auth::user()->id)->findByPoi($poi)->get()
        ];

        return view('establishment.employee.establishment-log')->with($data);
	}

    public function enrollStatus(Request $request)
    {

        $status = $request->status;
        $eeid = $request->eeid;

        $employee = People::find($eeid);

        $response['status'] = 'success';

        if ($status == 0) {
            $employee->delete();
            $response['message'] = 'Request has been deleted.';
        } else {
            $employee->status = $status;
            $employee->save();
            $response['message'] = 'Request has been approved.';
        }

        return Response::json($response);
    }

}
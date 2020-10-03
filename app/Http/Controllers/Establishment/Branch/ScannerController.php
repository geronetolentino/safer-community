<?php

namespace App\Http\Controllers\Establishment\Branch;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Response;
use Carbon\Carbon;

use App\Models\User;
use App\Models\People;
use App\Models\Scanner;
use App\Models\UserInfo;
use App\Models\Establishment;
use App\Models\EstablishmentEmployee;
use App\Models\EstablishmentVisitorLog;
use App\Models\EstablishmentScannerAccess;
use App\Models\AddrBarangay;
use App\Models\AddrMunicipality;
use App\Models\AddrProvince;

class ScannerController extends Controller
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
            'employees' => EstablishmentEmployee::findByEstId($branch->id)->get()
        ];

        return view('establishment.branch.single.scanner')->with($data);
    }

    public function list($est_code)
    {
        $branch = Establishment::findByEc($est_code);
    	$data = Scanner::findByEstId($branch->id)->get();

        return datatables()->of($data)
        ->addColumn('name', function($data){
            return '<b>'.$data->name.'</b>';
        })
        ->addColumn('status', function($data){
            return '<div class="td-content"><span class="badge outline-badge-'.$data->scannerStatus['color'].'">'.$data->scannerStatus['text'].'</span></div>';
        })
        ->addColumn('assigned_to', function($data){
            if ($data->assignedTo) {
                return $data->assignedTo->employee->resident->name.' - <a href="javascript:void(0);" class="btn-link assign-btn" data-employee="'.$data->assignedTo->employee->id.'" data-scanner="'.$data->name.'" data-id="'.$data->id.'">EDIT</a>';
            } else {
                return 'VACANT - <a href="javascript:void(0);" class="btn-link assign-btn" data-employee="0" data-scanner="'.$data->name.'" data-id="'.$data->id.'" data-action="create">Assign Employee</a>';
            }
        })
        ->addColumn('action', function($data){
            return '<button class="btn btn-outline-primary btn-sm edit" data-id="'.$data->id.'">Edit</button>';
        })
        ->rawColumns(['name','status','assigned_to','action'])
        ->addIndexColumn()
        ->make(true);
    }

    public function store(Request $request, $est_code)
    {
        $branch = Establishment::findByEc($est_code);

    	$scanner_name = $request->name;
    	$status = $request->status;
    	$owner_id = $branch->id;
    	$owner_type = 6;

    	$scanner = Scanner::firstOrCreate(
            [
                'owner_id' => $owner_id,
                'owner_type' => $owner_type,
                'name' => $scanner_name
            ],
            [
            	'uid' => strtoupper(Str::uuid().'-'.Str::random(10)),
            	'status' => $status,
            ]
        );

        if ($scanner->wasRecentlyCreated) { 

            $response['status'] = 'success';
            $response['message'] = 'Scanner added.';

        } else {

            $response['status'] = 'warning';
            $response['message'] = 'Scanner name already exist.';

        }
		
		return Response::json($response);
    }

    public function show(Request $request)
    {
        $data = Scanner::where('id', $request->id)->first();
     
        return Response::json($data);
    }

    public function update(Request $request)
    {

    	$id = $request->id;
    	$scanner_name = $request->name;
    	$status = $request->status;

    	$scanner = Scanner::find($id);
    	$scanner->name = $scanner_name;
    	$scanner->status = $status;
    	$scanner->save();

    	$response['status'] = 'success';
    	$response['message'] = 'Scanner update saved.';

    	return Response::json($response);
    }

    public function assign(Request $request, $est_code)
    {

    	$scanner_id = $request->scanner_id;
    	$employee = $request->employee_id;

        $establishment = Establishment::findByEc($est_code);

    	if ($employee == 0) {

    		EstablishmentScannerAccess::findByEstId($establishment->id)->findByScanner($scanner_id)->delete();

    		$response['status'] = 'success';
    		$response['message'] = 'Scanner set to vacant.';

    	} else {

    		$access = EstablishmentScannerAccess::updateOrCreate(
	            [
	                'establishment_id' => $establishment->id,
	                'employee_id' => $employee,
	                'scanner_id' => $scanner_id
	            ]
	        );

	        if ($access->wasRecentlyCreated) { 

	            $response['status'] = 'success';
	            $response['message'] = 'Scanner assigned to employee.';

	        } else {

	            $response['status'] = 'success';
	            $response['message'] = 'Scanner assigned to employee.';

	        }
    	}

    	return Response::json($response);

    }

}
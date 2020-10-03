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
use App\Models\HealthTest;
use App\Models\HospitalPatient;

class PatientHealthTestController extends Controller
{
    public function index($poi_id, $id)
    {
        $poi = UserInfo::poi($poi_id)->first();

        if (!$poi) {
            abort(404);
        }
        
        $data = [
            'pageName' => 'Patient Health Test',
            'navName' => 'Patient',
            'patient' => HospitalPatient::findByPoi($poi_id),
            'id' => $id,
        ];

        return view('hospital.patient.single.index')->with($data);
    }

    public function list($poi_id)
    {
    	$data = HealthTest::findByPoi($poi_id)->get();

        return datatables()->of($data)
            ->addColumn('test_date', function($data){
                return $data->test_date;
            })
            ->addColumn('test_result', function($data){
                return $data->test_result;
            })
            ->addColumn('symptom_category', function($data){
                return $data->symptom_category;
            })
            ->addColumn('remarks', function($data){
                return $data->remarks;
            })
            ->addColumn('action', function($data){
                //return '';
                return '<a href="'.route('hp.patient.health.test.diary',['poi_id'=>$data->poi_id, 'test_id'=>$data->id]).'" class="btn btn-outline-primary btn-sm">Test Diary</a>';
            })
            ->rawColumns(['test_date','test_result','symptom_category','remarks','action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request, $poi_id)
    {
    	HealthTest::create([
            'poi_id' => $poi_id,
            'test_date' => $request->test_date,
            'test_result' => $request->test_result,
            'symptom_category' => $request->symptom_category,
            'remarks' => $request->remarks
        ]);

        $response = [
            'status' => 'success',
            'message' => 'Health test has been added.'
        ];

        return Response::json($response);
    }

    public function destroy(Request $request)
    {

    }
}
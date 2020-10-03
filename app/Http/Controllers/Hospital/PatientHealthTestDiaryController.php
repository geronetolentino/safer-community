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
use App\Models\HealthTest;
use App\Models\HealthTestDiary;
use App\Models\HospitalPatient;

class PatientHealthTestDiaryController extends Controller
{
    public function index($poi_id, $test_id)
    {
        $poi = UserInfo::poi($poi_id)->first();

        if (!$poi) {
            abort(404);
        }

        $data = [
            'pageName' => 'Patient Health Data',
            'navName' => 'Patient',
            'test_id' => $test_id,
            'patient' => HospitalPatient::findByPoi($poi_id),
            'health_test' => HealthTest::find($test_id)
        ];

        return view('hospital.patient.single.diary')->with($data);
    }

    public function list($poi_id, $test_id)
    {
    	$data = HealthTestDiary::findByTestId($test_id)->get();

        return datatables()->of($data)
            ->addColumn('data_date', function($data){
                return $data->data_date;
            })
            ->addColumn('procedures', function($data){
                return $data->procedures;
            })
            ->addColumn('diagnosis', function($data){
                return $data->diagnosis;
            })
            ->addColumn('note', function($data){
                return $data->note;
            })
            ->addColumn('action', function($data){
                //return '<a href="'.route('hp.patient.single.test.diary',['id'=>$data->poi_id, 'test_id'=>$data->id]).'" class="btn btn-outline-primary btn-sm">Diary</a>';
            })
            ->rawColumns(['data_date','procedures','diagnosis','note','action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request, $poi_id, $test_id)
    {
        HealthTestDiary::create([
            'health_test_id' => $test_id,
            'procedures' => $request->procedures,
            'diagnosis' => $request->diagnosis,
            'data_date' => $request->data_date,
            'note' => $request->note,
            'hci_id' => Auth::user()->hospital->id,
        ]);

        $response = [
            'status' => 'success',
            'message' => 'Health test diary has been added.'
        ];

        return Response::json($response);
    }

    public function destroy($id)
    {

    }
}
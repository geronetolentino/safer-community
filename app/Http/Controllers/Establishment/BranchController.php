<?php

namespace App\Http\Controllers\Establishment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Response;
use Carbon\Carbon;

use App\Models\User;
use App\Models\UserInfo;
use App\Models\Establishment;
use App\Models\EstablishmentVisitorLog;
use App\Models\EstablishmentEmployee;
use App\Models\AddrBarangay;
use App\Models\AddrMunicipality;
use App\Models\AddrProvince;
use App\Models\HealthData;

class BranchController extends Controller
{
    public function index()
    {
        $data = [
            'pageName' => 'Branches',
            'navName' => 'Branches',
            'establishments' => Establishment::branches(Auth::user()->establishment->id)->get()
        ];

        return view('establishment.branch.index')->with($data);
    }

    public function list()
    {
    	$data = Establishment::branches(Auth::user()->establishment->id)->get();

        return datatables()->of($data)
        ->addColumn('branch', function($data){
            return '<b>'.$data->name.'</b><br>'.($data->parent_id == 0?'[Main Branch]':'');
        })
        ->addColumn('employees', function($data){
            return $data->employees->count();
        })
        ->addColumn('address', function($data){
            return $data->account->fullAddress;
        })
        ->addColumn('est_code', function($data){
            return $data->est_code;
        })
        ->addColumn('account', function($data){
            if ($data->account) {
                    return '<button class="btn btn-outline-danger btn-sm b account-btn" data-id="'.$data->account->id.'" data-action="reset">Reset Account</button>';
                } else {
                    return '<button class="btn btn-outline-primary btn-sm account-btn" data-id="'.$data->id.'" data-action="create">Generate</button>';
                }
        })
        ->addColumn('action', function($data){
            return '<a href="'.route('es.branch.single',['est_code'=>$data->est_code]).'" class="btn btn-outline-primary btn-sm">View</a>
            <a ></a>
            ';
        })
        ->rawColumns(['branch','employees','address','est_code','account','action'])
        ->addIndexColumn()
        ->make(true);
    }  

    public function store(Request $request)
    {
        $user = User::create([
            'type' => 6,
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'addr_barangay_id' => $request->addr_barangay_id,
            'addr_municipality_id' => $request->addr_municipality_id,
            'addr_province_id' => $request->addr_province_id,
            'addr_region_id' => 1,
        ]);

        UserInfo::create([
            'user_id' => $user->id,
            'profile_photo' => 'default-avatar.png',
            'phone_number' => null,
            'dob' => null,
            'poi_id' => null,
        ]);

        Establishment::create([
            'user_id' => $user->id,
            'parent_id' => Auth::user()->establishment->id,
            'name' => $request->name,
            'description' => null,
            'logo' => 'establishment-logo.png',
            'est_code' => substr($user->id . '-' . rand() . '-' . rand(), 0,30),
        ]);


        return Response::json(['status'=>'success','message'=>'Branch / account created.']);
    }  

    public function account(Request $request)
    {
        $action = $request->action;
        $id = $request->id;

        $message = 'Account has been reseted.';
        $user = User::find($id);

        $establishment = Establishment::findByUser($id);
        $name = strtolower($establishment->name);
        $name = str_replace(' ', '', $name);
        $password = $name.'-'.rand();

        if (!$user->username) {
            $user->username = strtoupper($name);
        }
        $user->password = Hash::make($password);
        $user->save();

        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => [
                'username' => $user->username,
                'password' => $password
            ]
        ];

        return Response::json($response);

    }

    public function single($est_code)
    {
        $branch = Establishment::findByEc($est_code);

        if (!$branch)
            return redirect()->route('es.branch');

        $logs = EstablishmentVisitorLog::selectRaw('count(est_code) as count, MONTHNAME(created_at) as month')
        ->estcode($branch->est_code)
        ->groupBy('month')
        ->orderBy('month','asc')
        ->get();

        $data = [
            'pageName' => 'View Branch ['.$branch->name.']',
            'navName' => 'Branches',
            'branch' => $branch,
            'logs' => $logs
        ];

        return view('establishment.branch.single.home')->with($data);
    }

    public function poiList($est_code)
    {
        $visitors = EstablishmentVisitorLog::select('poi_id')
        ->estcode($est_code)
        ->get()->toArray();

        $data = HealthData::poids($visitors)->orderBy('updated_at', 'desc')->get();

        return datatables()->of($data)
            ->addColumn('id', function($data){
                return 'POI#: <strong>'.$data->poi_id.'</strong>';
            })
            ->addColumn('status', function($data){
                return $data->current_status;
            })
            ->rawColumns(['id', 'status'])
            ->addIndexColumn()
            ->make(true);
    }
}
<?php

namespace App\Http\Controllers\ProvincialAdministrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Response;

use App\Models\AddrBarangay;
use App\Models\AddrMunicipality;
use App\Models\AddrProvince;
use App\Models\Hospital;
use App\Models\User;
use App\Models\UserInfo;

class HospitalController extends Controller
{
    public function index()
    {
        $data = [
            'pageName' => 'Hospital',
            'navName' => 'Hospital', 
        ];

        return view('provincial-admin.hospital.index')->with($data);
    }

    public function list()
    {

        $data = Hospital::whereHas('account', function($query) {
            $query->where('addr_province_id', '=', Auth::user()->addr_province_id);
        })->get();

        return datatables()->of($data)
            ->addColumn('name', function($data){
                return '<b>'.$data->name.'</b>';
            })
            ->addColumn('address', function($data){
                return $data->account->fullAddress;
            })
            ->addColumn('account', function($data){
                if ($data->account) {
                    return '<button class="btn btn-outline-danger btn-sm b account-btn" data-id="'.$data->account->id.'" data-action="reset">Reset Account</button>';
                } else {
                    return '<button class="btn btn-outline-primary btn-sm account-btn" data-id="'.$data->id.'" data-action="create">Generate</button>';
                }
            })
            ->addColumn('status', function($data){
                return '<b class="text-'.$data->hospitalStatus['color'].'">'.$data->hospitalStatus['text'].'</b>';
            })
            ->addColumn('action', function($data){
                //return '<a href="'.route('pa.hospital.view',['id'=>$data->id]).'" class="btn btn-outline-primary btn-sm">View</a>';
                return '';
            })
            ->rawColumns(['name','address','account','status','action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function view($id) 
    {
        $data = [
            'pageName' => 'Hospital Dashboard',
            'navName' => 'Hospital',
            'qry' => Hospital::find($id)
        ];

        return view('provincial-admin.hospital.view')->with($data);
    }

    public function store(Request $request)
    {

    	$hospital = Hospital::firstOrCreate(
            [
                'name' => $request->name, 
            ],
            [ 
                'status' => 1
            ]
        );

        if ($hospital->wasRecentlyCreated) {

            $user = User::create([
                'type' => 5,
                'username' => $request->username,
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'addr_barangay_id' => $request->addr_barangay_id,
                'addr_municipality_id' => $request->addr_municipality_id,
                'addr_province_id' => Auth::user()->addr_province_id,
                'addr_region_id' => Auth::user()->addr_region_id,
            ]);

            UserInfo::create([
                'user_id' => $user->id,
                'profile_photo' => 'default-avatar.png',
                'phone_number' => null,
                'dob' => null,
                'poi_id' => null,
            ]);

            $hospital->user_id = $user->id;
            $hospital->save();

            $response['status'] = 'success';
            $response['message'] = 'Hospital account saved.';

        } else {

            $response['status'] = 'warning';
            $response['message'] = 'Hospital already exist.';

        }
		
		return Response::json($response);
    }

    public function edit($id)
    {

    }

    public function save(Request $request)
    {

    }

    public function account(Request $request)
    {
        $action = $request->action;
        $id = $request->id;

        if ($action == 'reset') {

            $message = 'Account has been reseted.';
            $user = User::find($id);

            $hospital = Hospital::findByUser($id);
            $name = strtolower($hospital->name);
            $name = str_replace(' ', '-', $name);
            $password = $name.'-'.rand();
            if (!$user->username) {
                $user->username = $name;
            }
            $user->password = Hash::make($password);
            $user->save();

        } else {

            $message = 'Account has been created.';
            $hospital = Hospital::find($id);
            $name = strtolower($hospital->name);
            $name = str_replace(' ', '_', $name);
            $password = $name.'-'.rand();

            $user = User::create([
                'type' => 5,
                'username' => $name,
                'name' => $name,
                'email' => null,
                'password' => Hash::make($password),
                'addr_barangay_id' => 0,
                'addr_municipality_id' => 0,
                'addr_province_id' => 1,
                'addr_region_id' => 1,
            ]);

            $hospital->user_id = $user->id;
            $hospital->save();

        }

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


}
<?php

namespace App\Http\Controllers\MunicipalAdministrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Response;

use App\Models\User;
use App\Models\UserInfo;
use App\Models\AddrBarangay;

class BarangayController extends Controller
{
    public function index()
    {
        $data = [
            'pageName' => 'Barangay',
            'navName' => 'Barangay'
        ];

        return view('municipal-admin.barangay.index')->with($data);
    }

    public function list()
    {
    	$data = AddrBarangay::municipalityOf(['city_municipality_code', Auth::user()->addr_municipality_id])->get();

        return datatables()->of($data)
            ->addColumn('barangay', function($data){
                return '<b>'.$data->barangay_description.'</b>';
            })
            ->addColumn('resident', function($data){
                return $data->residents->count();
            })
            ->addColumn('account', function($data){
                if ($data->account) {
                    return '<button class="btn btn-outline-danger btn-sm b account-btn" data-id="'.$data->account->id.'" data-action="reset">Reset Account</button>';
                } else {
                    return '<button class="btn btn-outline-primary btn-sm account-btn" data-id="'.$data->id.'" data-action="create">Generate</button>';
                }
            })
            ->addColumn('action', function($data){
                //return '<a href="'.route('ma.barangay.view',['id'=>$data->id]).'" class="btn btn-outline-primary btn-sm">View</a>';
                return '';
            })
            ->rawColumns(['barangay','resident','account','action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function view($id) 
    {
        $data = [
            'pageName' => 'Municipality Dashboard',
            'navName' => 'Municipality',
            'qry' => AddrBarangay::find($id)
        ];

        return view('provincial-admin.municipality.view')->with($data);
    }


    public function store(Request $request)
    {

    	$barangay = AddrBarangay::firstOrCreate(
            [
                'barangay_code' => $request->code,
                'city_municipality_code' => Auth::user()->addr_municipality_id
            ],
            [
                'barangay_description' => $request->barangay,
                'region_code' => Auth::user()->addr_region_id,
                'province_code' => Auth::user()->addr_province_id
            ]
        );

        if ($barangay->wasRecentlyCreated) { 

            $response['status'] = 'success';
            $response['message'] = 'Data saved.';

        } else {

            $response['status'] = 'warning';
            $response['message'] = 'Barangay already exist.';

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

            $barangay = AddrBarangay::findByUser($id);
            $name = strtolower($barangay->barangay_description);
            $name = str_replace(' ', '', $name);
            $password = $name.'-'.rand();

            $user->password = Hash::make($password);
            $user->save();

        } else {

            $message = 'Account has been created.';
            $barangay = AddrBarangay::find($id);
            $name = strtolower($barangay->barangay_description);
            $name = str_replace(' ', '', $name);
            $password = $name.'-'.rand();

            $user = User::create([
                'type' => 3,
                'username' => $name,
                'name' => $name,
                'email' => null,
                'password' => Hash::make($password),
                'addr_barangay_id' => $barangay->barangay_code,
                'addr_municipality_id' => $barangay->city_municipality_code,
                'addr_province_id' => $barangay->province_code,
                'addr_region_id' => $barangay->region_code,
            ]);

            UserInfo::create([
                'user_id' => $user->id,
                'profile_photo' => 'default-avatar.png',
                'phone_number' => null,
                'dob' => null,
                'poi_id' => null,
            ]);

            $barangay->user_id = $user->id;
            $barangay->save();

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
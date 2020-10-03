<?php

namespace App\Http\Controllers\ProvincialAdministrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Response;

use App\Models\User;
use App\Models\UserInfo;
use App\Models\AddrMunicipality;

class MunicipalityController extends Controller
{
    public function index()
    {
        $data = [
            'pageName' => 'Municipality',
            'navName' => 'Municipality'
        ];

        return view('provincial-admin.municipality.index')->with($data);
    }

    public function list()
    {
    	$data = AddrMunicipality::select('id','user_id','city_municipality_description','city_municipality_code')
        ->provinceCode(Auth::user()->addr_province_id)
        ->get();

        return datatables()->of($data)
            ->addColumn('municipality', function($data){
                return '<b>'.$data->city_municipality_description.'</b>';
            })
            ->addColumn('barangay', function($data){
                return $data->barangays->count();
            })
            ->addColumn('community', function($data){
                return 'Residents: '.$data->residents->count().'<br> Hospitals: '.$data->hospitals->count().'<br> Establishments: '.$data->establishments->count();
            })
            ->addColumn('account', function($data){
                if ($data->account) {
                    return '<button class="btn btn-outline-danger btn-sm account-btn" data-id="'.$data->account->id.'" data-action="reset">Reset Account</button>';
                } else {
                    return '<button class="btn btn-outline-primary btn-sm account-btn" data-id="'.$data->city_municipality_code.'" data-action="create">Generate</button>';
                }
            })
            ->addColumn('action', function($data){
                //return '<a href="'.route('pa.municipality.view',['id'=>$data->id]).'" class="btn btn-outline-primary btn-sm">View</a>';
                return '';
            })
            ->rawColumns(['municipality','barangay','account','community','action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function view($id) 
    {
        $data = [
            'pageName' => 'Municipality Dashboard',
            'navName' => 'Municipality',
            'qry' => AddrMunicipality::find($id)
        ];

        return view('provincial-admin.municipality.view')->with($data);
    }

    public function store(Request $request)
    {

    	$municipality = AddrMunicipality::firstOrCreate(
            [
                'city_municipality_code' => $request->code,
                'province_code' => Auth::user()->addr_province_id
            ],
            [
                'city_municipality_description' => $request->municipality,
                'region_code' => Auth::user()->addr_region_id
            ]
        );

        if ($municipality->wasRecentlyCreated) { 

            $response['status'] = 'success';
            $response['message'] = 'Data saved.';

        } else {

            $response['status'] = 'warning';
            $response['message'] = 'Municipality/City already exist.';

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

            $municipality = AddrMunicipality::findByUser($id);
            $name = strtolower($municipality->city_municipality_description);
            $name = str_replace(' ', '', $name);
            $password = $name.'-'.rand();

            $user->password = Hash::make($password);
            $user->save();

        } else {

            $message = 'Account has been created.';
            $municipality = AddrMunicipality::cityMunicipalityCode($id)->first();
            $name = strtolower($municipality->city_municipality_description);
            $name = str_replace(' ', '', $name);
            $password = $name.'-'.rand();

            $user = User::create([
                'type' => 2,
                'username' => $name,
                'name' => $name,
                'email' => null,
                'password' => Hash::make($password),
                'addr_barangay_id' => '010000001x',
                'addr_municipality_id' => $municipality->city_municipality_code,
                'addr_province_id' => $municipality->province_code,
                'addr_region_id' => $municipality->region_code,
            ]);

            UserInfo::create([
                'user_id' => $user->id,
                'profile_photo' => 'default-avatar.png',
                'phone_number' => null,
                'dob' => null,
                'poi_id' => null,
            ]);

            $municipality->user_id = $user->id;
            $municipality->save();

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
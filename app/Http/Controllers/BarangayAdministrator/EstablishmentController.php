<?php

namespace App\Http\Controllers\BarangayAdministrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Response;

use App\Models\Establishment;
use App\Models\User;

class EstablishmentController extends Controller
{
    public function index()
    {
        $data = [
            'pageName' => 'Establishment',
            'navName' => 'Establishment'
        ];

        return view('municipal-admin.establishment.index')->with($data);
    }

    public function list()
    {
    	$data = Establishment::latest()->get();

        return datatables()->of($data)
            ->addColumn('establishment', function($data){
                return '<b>'.$data->establishment.'</b>';
            })
            ->addColumn('address', function($data){
                return $data->address;
            })
            ->addColumn('status', function($data){
                return '<b class="text-'.$data->establishmentStatus['color'].'">'.$data->establishmentStatus['text'].'</b>';
            })
            ->addColumn('action', function($data){
                return '<a href="'.route('pa.Establishment.view',['id'=>$data->id]).'" class="btn btn-outline-primary btn-sm">View</a>';
            })
            ->rawColumns(['establishment','address','status','action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function view($id) 
    {
        $data = [
            'pageName' => 'Establishment Dashboard',
            'navName' => 'Establishment',
            'qry' => Establishment::find($id)
        ];

        return view('municipal-admin.establishment.view')->with($data);
    }


    public function store(Request $request)
    {

    	$establishment = Establishment::firstOrCreate(
            ['name' => $request->establishment ,  
            'address' => $request->address],
            ['addr_province_id' => Auth::user()->addr_province_id , 'status' => $request->status]
        );

        if ($establishment->wasRecentlyCreated) { 
            User::create([
                'type' => 4,
                'name' => $request->establishment,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'territory' => Auth::user()->territory
            ]);

            $response['status'] = 'success';
            $response['message'] = 'Data saved.';

        } else {

            $response['status'] = 'warning';
            $response['message'] = 'Establishment already exist.';

        }
		
		return Response::json($response);
    }

    public function edit($id)
    {

    }

    public function save(Request $request)
    {

    }


}
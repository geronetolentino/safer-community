<?php

namespace App\Http\Controllers\WebAdmin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'pageName' => 'Dashboard',
            'navName' => 'Dashboard',
        ];

        return view('web-admin.home')->with($data);
    }

    public function list()
    {
    	$data = User::get();

        return datatables()->of($data)
            ->addColumn('resident', function($data){
                return '<b>'.$data->name.'</b><br>'.'POI: '.$data->info->poi_id;
            })
            ->addColumn('documents', function($data){
                return $data->documents->count();
            })
            ->addColumn('action', function($data){
                return '<a href="'.route('ma.barangay.view',['id'=>$data->id]).'" class="btn btn-outline-primary btn-sm">View</a>';
            })
            ->rawColumns(['resident','documents','barangay','action'])
            ->addIndexColumn()
            ->make(true);
    }


}
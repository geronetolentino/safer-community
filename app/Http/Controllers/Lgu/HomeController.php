<?php

namespace App\Http\Controllers\Lgu;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\HealthData;

class HomeController extends Controller
{
    public function index()
    {

        $data = [
            'pageName' => 'Dashboard',
            'navName' => 'Dashboard',
        ];

        return view('user-lgu.home')->with($data);
    }

    // public function positiveList()
    // {
    //     $residents = UserInfo::select('poi_id')
    //     ->with('user')
    //     ->whereHas('user', function($query) {
    //         $query->residentOf(['addr_municipality_id', Auth::user()->addr_municipality_id]);
    //     })
    //     ->get()->toArray();

    //     $data = HealthData::case('Covid-19 Positive')->poids($residents)->orderBy('updated_at', 'desc')->get();

    //     return datatables()->of($data)
    //         ->addColumn('id', function($data){
    //             return 'POI#: <strong>'.$data->poi_id.'</strong>';
    //         })
    //         ->rawColumns(['id'])
    //         ->addIndexColumn()
    //         ->make(true);
    // }

    // public function puiList()
    // {
    //     $residents = UserInfo::select('poi_id')
    //     ->with('user')
    //     ->whereHas('user', function($query) {
    //         $query->residentOf(['addr_municipality_id', Auth::user()->addr_municipality_id]);
    //     })
    //     ->get()->toArray();

    //     $data = HealthData::case('PUI')->poids($residents)->orderBy('updated_at', 'desc')->get();

    //     return datatables()->of($data)
    //         ->addColumn('id', function($data){
    //             return 'POI#: <strong>'.$data->poi_id.'</strong>';
    //         })
    //         ->rawColumns(['id'])
    //         ->addIndexColumn()
    //         ->make(true);
    // }

    // public function pumList()
    // {
    //     $residents = UserInfo::select('poi_id')
    //     ->with('user')
    //     ->whereHas('user', function($query) {
    //         $query->residentOf(['addr_municipality_id', Auth::user()->addr_municipality_id]);
    //     })
    //     ->get()->toArray();

    //     $data = HealthData::case('PUM')->poids($residents)->orderBy('updated_at', 'desc')->get();

    //     return datatables()->of($data)
    //         ->addColumn('id', function($data){
    //             return 'POI#: <strong>'.$data->poi_id.'</strong>';
    //         })
    //         ->rawColumns(['id'])
    //         ->addIndexColumn()
    //         ->make(true);
    // }
}
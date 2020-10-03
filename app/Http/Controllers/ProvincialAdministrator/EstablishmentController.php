<?php

namespace App\Http\Controllers\ProvincialAdministrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Response;
use Carbon\Carbon;

use App\Models\Establishment;
use App\Models\EstablishmentVisitorLog;
use App\Models\EstablishmentEmployee;
use App\Models\User;

class EstablishmentController extends Controller
{
    public function index()
    {
        $data = [
            'pageName' => 'Establishment',
            'navName' => 'Establishment'
        ];

        return view('provincial-admin.establishment.index')->with($data);
    }

    public function list()
    {
    	$data = Establishment::latest()->get();

        return datatables()->of($data)
            ->addColumn('establishment', function($data){
                return '<strong>'.$data->name.'</strong><br><small>'.$data->est_code.'</small>';
            })
            ->addColumn('address', function($data){
                return $data->account->fullAddress;
            })
            ->addColumn('status', function($data){
                return '<b class="text-'.$data->establishmentStatus['color'].'">'.$data->establishmentStatus['text'].'</b>';
            })
            ->addColumn('action', function($data){
                return '<a href="'.route('pa.establishment.single',['est_code'=>$data->est_code]).'" class="btn btn-outline-primary btn-sm">Dashboard</a>';
            })
            ->rawColumns(['establishment','address','status','action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function single($est_code) 
    {

        $establishment = Establishment::findByEc($est_code);

        if (!$establishment)
            return redirect()->route('pa.establishment');

        $logs = EstablishmentVisitorLog::selectRaw('count(est_code) as count, MONTHNAME(created_at) as month')
        ->estcode($establishment->est_code)
        ->groupBy('month')
        ->orderBy('month','asc')
        ->get();

        $data = [
            'pageName' => 'Establishment Dashboard ['.$establishment->name.']',
            'navName' => 'Establishment',
            'establishment' => $establishment,
            'logs' => $logs
        ];

        return view('provincial-admin.establishment.single')->with($data);
    }

    // public function branchVisitor($est_code)
    // {
    //     $data = EstablishmentVisitorLog::estcode($est_code)->get();

    //     return datatables()->of($data)
    //         ->addColumn('visitor', function($data){
    //             return '<b>POI: '.$data->person->poi_id.'</b>';
    //         })
    //         ->addColumn('date', function($data){
    //             $in = Carbon::parse($data->checkin)->format('M d Y - g:i A');

    //             if ($data->status == 'OUT') {

    //                 $out = Carbon::parse($data->checkout)->format('M d Y - g:i A');

    //             } else {

    //                 $out = null;

    //             }

    //             return 'IN: '.$in.'<br>OUT: '.$out;
    //         })
    //         ->addColumn('status', function($data){
    //             return $data->status;
    //         })
    //         ->addColumn('action', function($data){
    //             return '<a href="" class="btn btn-outline-primary btn-sm"></a>';
    //         })
    //         ->rawColumns(['visitor','date','status','action'])
    //         ->addIndexColumn()
    //         ->make(true);
    // }

    // public function branchEmployee($id)
    // {
    //     $data = EstablishmentEmployee::findByEstId($id)->get();

    //     return datatables()->of($data)
    //         ->addColumn('employee', function($data){
    //             return '<b>POI: '.$data->resident->name.'</b><br>'.$dat->resident->info->poi_id;
    //         })
    //         ->addColumn('address', function($data){
    //             return $data->resident->fullAddress;
    //         })
    //         ->addColumn('action', function($data){
    //             return '<a href="" class="btn btn-outline-primary btn-sm"></a>';
    //         })
    //         ->rawColumns(['employee','address','action'])
    //         ->addIndexColumn()
    //         ->make(true);
    // }
}
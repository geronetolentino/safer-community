<?php

namespace App\Http\Controllers\ProvincialAdministrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

use App\Models\Visit;
use App\Models\EstablishmentVisitorLog;

class VisitorController extends Controller
{
    public function index()
    {
        $data = [
            'pageName' => 'Visitors',
            'navName' => 'Visitors',
        ];

        return view('provincial-admin.visitors.index')->with($data);
    }

    public function list($est_code)
    {
        $data = EstablishmentVisitorLog::estcode($est_code)->get();

        return datatables()->of($data)
            ->addColumn('visitor', function($data){
                return '<b>POI: '.$data->person->poi_id.'</b>';
            })
            ->addColumn('date', function($data){
                $in = Carbon::parse($data->checkin)->format('M d Y - g:i A');

                if ($data->status == 'OUT') {

                    $out = Carbon::parse($data->checkout)->format('M d Y - g:i A');

                } else {

                    $out = null;

                }

                return 'IN: '.$in.'<br>OUT: '.$out;
            })
            ->addColumn('status', function($data){
                return $data->status;
            })
            ->addColumn('action', function($data){
                return '<a href="" class="btn btn-outline-primary btn-sm"></a>';
            })
            ->rawColumns(['visitor','date','status','action'])
            ->addIndexColumn()
            ->make(true);
    }


}
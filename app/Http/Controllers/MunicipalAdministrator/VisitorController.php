<?php

namespace App\Http\Controllers\MunicipalAdministrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

use App\Models\Visit;
use App\Models\VisitingResident;

class VisitorController extends Controller
{
    public function index()
    {
        $data = [
            'pageName' => 'Visitors',
            'navName' => 'Visitors',
        ];

        return view('municipal-admin.visitors.index')->with($data);
    }

    public function list()
    {
        $data = VisitingResident::findByAddrMunicipal(auth()->user()->addr_municipality_id)->with('purpose')->orderBy('created_at', 'desc')->get();

        return datatables()->of($data)
            ->addColumn('visitor', function($data){
                return 'POI #: <strong>'.$data->poi_id.'</strong>';
            })
            ->addColumn('reason_of_visit', function($data){
                return $data->purpose->purpose;
            })
            ->addColumn('created_at', function($data){
                return date('M d Y - g:i A', strtotime($data->created_at));
            })
            ->addColumn('status', function($data){
                if ($data->status == 0) {
                    return '<a href="'.route('ma.visitor.approve', $data->id).'" class="btn btn-sm btn-primary">Approve Visit</a>';
                } else {
                    return 'Approved Visit';
                }
            })
            ->rawColumns(['visitor','reason_of_visit','created_at','status'])
            ->addIndexColumn()
            ->make(true);
    }

    public function approve($id)
    {
        $visitresident = VisitingResident::findOrFail($id);
        $visitresident->update([
            'status' => 1,
        ]);

        if ($visitresident) {
            return redirect()->back()->with('success', 'Visit had been approved.');
        }
        else {
            return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
        }
        
    }


}
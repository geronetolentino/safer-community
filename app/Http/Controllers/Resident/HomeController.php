<?php

namespace App\Http\Controllers\Resident;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Response;

use App\Models\Visit;
use App\Models\People;
use App\Models\UserInfo;
use App\Models\Establishment;
use App\Models\EstablishmentEmployee;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'pageName' => 'Dashboard',
            'navName' => 'Dashboard',
        ];

        return view('resident.home')->with($data);
    }

    public function visits()
    {
        $data = [
            'pageName' => 'Dashboard',
            'navName' => 'Dashboard',
        ];

        return view('resident.home')->with($data);
    }

    public function enrollEmployee($eep)
    {
        $warning = false;
        
        if (Auth::user()->type !== 4){
            $warning = true;
        }

        $establishment = Establishment::findByEc($eep);
        
        if (!$establishment) 
            abort(404);

        $existEmployeer = EstablishmentEmployee::user(Auth::user()->id)->approved()->first();

        $data = [
            'pageName' => 'Dashboard',
            'navName' => 'Dashboard',
            'establishment' => $establishment,
            'existing' => $existEmployeer,
            'warning' => $warning
        ];

        return view('resident.enroll')->with($data);
    }

    public function enrollEmployeeConfirm(Request $request)
    {

        $employee = People::firstOrCreate(
            [
                'head_id' => $request->id,
                'child_id' => Auth::user()->id
            ],
            [
                'status' => 0
            ]
        );

        if ($employee->wasRecentlyCreated) { 

            $response['status'] = 'success';
            $response['message'] = 'Your enrollment as employee successfully sent.';

        } else {

            $response['status'] = 'warning';
            $response['message'] = 'You already sent your enrollment request.';

        }

        return Response::json($response);
    }

}
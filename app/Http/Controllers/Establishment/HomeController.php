<?php

namespace App\Http\Controllers\Establishment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\People;
use App\Models\Establishment;
use App\Models\EstablishmentVisitorLog;

class HomeController extends Controller
{
    public function index()
    {
    	$branches = Establishment::branches(Auth::user()->establishment->id)->get();
    	
        $data = [
            'pageName' => 'Dashboard',
            'navName' => 'Dashboard',
            'branches' => $branches,
            'employees' => People::establishment(Auth::user()->id)->get(),
            'visits' => EstablishmentVisitorLog::whereIn('est_code', $branches->pluck('est_code'))->get()
        ];

        return view('establishment.home')->with($data);
    }


}
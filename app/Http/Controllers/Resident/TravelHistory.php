<?php

namespace App\Http\Controllers\Resident;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class TravelHistory extends Controller
{
    public function index()
    {
        $data = [
            'pageName' => 'Travel History',
            'navName' => 'Travel',
            'est_logs' => Auth::user()->establishmentLog,
        ];

        return view('resident.travel.index')->with($data);
    }


}
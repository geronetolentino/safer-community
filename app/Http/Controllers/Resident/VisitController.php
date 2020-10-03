<?php

namespace App\Http\Controllers\Resident;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Visit;

class VisitController extends Controller
{
    public function index()
    {
        $data = [
            'pageName' => 'My Profile',
            'navName' => 'My Profile',
        ];

        return view('resident.home')->with($data);
    }


}
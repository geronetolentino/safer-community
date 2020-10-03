<?php

namespace App\Http\Controllers\BarangayAdministrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Visit;

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

    public function list()
    {
    	$visitors = Visit::all();
        return DataTables::of($visitors)->make();
    }


}
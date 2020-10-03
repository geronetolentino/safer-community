<?php

namespace App\Http\Controllers\Resident;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Visit;

class DocumentController extends Controller
{
    public function index()
    {
        $data = [
            'pageName' => 'Documents',
            'navName' => 'Documents',
        ];

        return view('resident.documents.index')->with($data);
    }

}
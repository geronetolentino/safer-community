<?php

namespace App\Http\Controllers\Resident;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Response;

use App\Models\User;
use App\Models\UserInfo;
use App\Models\AccessLog;

class AccessLogController extends Controller
{
    public function index()
    {
    	$logs =  AccessLog::findByPoi(Auth::user()->info->poi_id)->latest()->get();

        $data = [
            'pageName' => 'Information Access Logs',
            'navName' => 'Info Access Logs',
            'logs' => $logs,
        ];

        return view('resident.access-logs.index')->with($data);
    }

}
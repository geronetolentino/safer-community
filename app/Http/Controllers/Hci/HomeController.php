<?php

namespace App\Http\Controllers\Hci;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Response;
use Carbon\Carbon;

use App\Models\Checklist;
use App\Models\ChecklistDailyItem;
use App\Models\ChecklistDailyTotal;
use App\Models\Hospital;
use App\Models\HospitalPatient;

class HomeController extends Controller
{
    public function index()
    {

    	$conditions = [
    		'severe' => ChecklistDailyTotal::condition('Severe Condition')->get(),
    		'mild' => ChecklistDailyTotal::condition('Mild Condition')->get(),
    		'good' => ChecklistDailyTotal::condition('Good Condition')->get(),
    	];

        $data = [
            'pageName' => 'Dashboard',
            'navName' => 'Dashboard',
            'conditions' => $conditions,
            'patients' => HospitalPatient::get(),

        ];

        return view('user-hci.home')->with($data);
    }


}
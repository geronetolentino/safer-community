<?php

namespace App\Http\Controllers\ProvincialAdministrator;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\UserInfo;
use App\Models\HealthData;

class HomeController extends Controller
{
    public function index()
    {

        $province = Auth::user()->addr_province_id;

        $residents = UserInfo::select('poi_id')
        ->with('user')
        ->whereHas('user', function($query) use ($province)  {
            $query->residentOf(['addr_province_id', $province]);
        })
        ->get()->pluck('poi_id')->toArray();

        $positive_overall = HealthData::case('Covid-19 Positive')->poids($residents)->count();

        $positive_monthly = HealthData::selectRaw('count(id) as count, MONTH(created_at) as month')
        ->where('created_at', 'LIKE', date('Y').'%')
        ->case('Covid-19 Positive')
        ->poids($residents)
        ->orderBy('month')
        ->groupBy('month')
        ->get();

        $pui_overall = HealthData::case('PUI')->poids($residents)->count();

        $pui_monthly = HealthData::selectRaw('count(id) as count, MONTH(created_at) as month')
        ->where('created_at', 'LIKE', date('Y').'%')
        ->case('PUI')
        ->poids($residents)
        ->orderBy('month')
        ->groupBy('month')->get();

        $pum_overall = HealthData::case('PUM')->poids($residents)->count();

        $pum_monthly = HealthData::selectRaw('count(id) as count, MONTH(created_at) as month')
        ->where('created_at', 'LIKE', date('Y').'%')
        ->case('PUM')
        ->poids($residents)
        ->orderBy('month')
        ->groupBy('month')->get();

        $data = [
            'pageName' => 'Dashboard',
            'navName' => 'Dashboard',
            'positive_overall' => $positive_overall,
            'positive_monthly' => $positive_monthly,
            'pui_overall' => $pui_overall,
            'pui_monthly' => $pui_monthly,
            'pum_overall' => $pum_overall,
            'pum_monthly' => $pum_monthly,
        ];

        return view('provincial-admin.home')->with($data);
    }


}
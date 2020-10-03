<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Response;

use App\Models\AddrBarangay;
use App\Models\AddrMunicipality;
use App\Models\AddrProvince;
use App\Models\AddrRegion;

class AddressController extends Controller
{

	public function regions() 
	{
		$data = AddrRegion::select('region_code','region_description')
		->orderBy('region_description', 'ASC')
		->get();

		return Response::json(['regions'=>$data]);
	}

    public function provinces(Request $request)
    {
        $data = AddrProvince::select('province_code','province_description')
        ->regionCode($request->code)
		->orderBy('province_description', 'ASC')
        ->get();

		return Response::json(['provinces'=>$data]);
    }

    public function cityMunicipalities(Request $request)
    {
        $data = AddrMunicipality::select('city_municipality_code','city_municipality_description')
        ->provinceCode($request->code)
		->orderBy('city_municipality_description', 'ASC')
        ->get();

		return Response::json(['cities_municipalities'=>$data]);
    }

    public function barangays(Request $request)
    {
        $data = AddrBarangay::select('barangay_code','barangay_description')
        ->cityMunicipalityCode($request->code)
		->orderByRaw('LENGTH(barangay_description) ASC')
        ->get();

		return Response::json(['barangays'=>$data]);
    }


}
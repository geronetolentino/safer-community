<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Response;

use App\Models\PhilippineBarangay;
use App\Models\PhilippineCity;
use App\Models\PhilippineProvince;
use App\Models\PhilippineRegion;

class AddressController extends Controller
{

	public function regions() 
	{
		$data = PhilippineRegion::select('region_code','region_description')
		->orderBy('region_description', 'ASC')
		->get();

		return Response::json(['regions'=>$data]);
	}

    public function provinces(Request $request)
    {
        $data = PhilippineProvince::select('province_code','province_description')
        ->regionCode($request->code)
		->orderBy('province_description', 'ASC')
        ->get();

		return Response::json(['provinces'=>$data]);
    }

    public function cityMunicipalities(Request $request)
    {
        $data = PhilippineCity::select('city_municipality_code','city_municipality_description')
        ->provinceCode($request->code)
		->orderBy('city_municipality_description', 'ASC')
        ->get();

		return Response::json(['cities_municipalities'=>$data]);
    }

    public function barangays(Request $request)
    {
        $data = PhilippineBarangay::select('barangay_code','barangay_description')
        ->cityMunicipalityCode($request->code)
		->orderByRaw('LENGTH(barangay_description) ASC')
        ->get();

		return Response::json(['barangays'=>$data]);
    }


}
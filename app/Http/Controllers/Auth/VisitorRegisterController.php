<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserInfo;
use App\Models\Establishment;
use App\Models\VisitingResident;

class VisitorRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['required', 'string', 'max:13', 'unique:visiting_residents'],
            'origin_barangay' => ['required'],
            'origin_municipality' => ['required'],
            'origin_province' => ['required'],
            'origin_region' => ['required'],
          
            'address' => ['string'],
            'addr_barangay_id' => ['required'],
            'addr_municipality_id' => ['required'],
            'addr_province_id' => ['required'],
            'addr_region_id' => ['required'],
            'reason' => ['required'],
            'days_to_stay' => ['required'],
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        if ($response = $this->create($request->all())) {
            return redirect()->route('login')->with('success', 'Visitor successfully registered.');
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $poi_id = substr(strtoupper(Str::random(5)).'-'.rand().'-'.rand(), 0,30);
        $visitor = VisitingResident::create([
            'username' => $data['username'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_number' => $data['phone_number'],
            'poi_id' => $poi_id,

            'org_addr_barangay' => $data['origin_barangay'],
            'org_addr_municipality' => $data['origin_municipality'],
            'org_addr_province' => $data['origin_province'],
            'org_addr_region' => $data['origin_region'],

            'address' => $data['origin_address'],

            'des_addr_barangay_id' => $data['addr_barangay_id'],
            'des_addr_municipality_id' => $data['addr_municipality_id'],
            'des_addr_province_id' => $data['addr_province_id'],
            'des_addr_region_id' => $data['addr_region_id'],

            'reason_visit' => $data['reason'],
            'days_stay' => $data['days_to_stay'],
        ]);

        if ($visitor) {
        	return $visitor;
        }
        else {
        	return redirect()->route('login')->with('error', 'Something went wrong. Please try again later.');
        }
    }
}

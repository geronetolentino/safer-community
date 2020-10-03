<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\UserInfo;
use App\Models\Establishment;

class RegisterController extends Controller
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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'type' => ['required'],
            'username' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['required', 'string', 'max:13', 'unique:user_infos'],
            'addr_barangay_id' => ['required'],
            'addr_municipality_id' => ['required'],
            'addr_province_id' => ['required'],
            'addr_region_id' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'type' => $data['type'],
            'username' => $data['username'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'addr_barangay_id' => $data['addr_barangay_id'],
            'addr_municipality_id' => $data['addr_municipality_id'],
            'addr_province_id' => $data['addr_province_id'],
            'addr_region_id' => $data['addr_region_id'],
        ]);

        $poi_id = substr(strtoupper(Str::random(5)).'-'.rand().'-'.rand(), 0,30);
        UserInfo::create([
            'user_id' => $user->id,
            'profile_photo' => 'default-avatar.png',
            'phone_number' => $data['phone_number'],
            'dob' => null,
            'poi_id' => $data['type']==4?$poi_id:null,
        ]);

        if ($data['type'] == 6) {
            Establishment::create([
                'user_id' => $user->id,
                'parent_id' => 0,
                'name' => $data['name'],
                'description' => null,
                'logo' => 'establishment-logo.png',
                'est_code' => substr($user->id . '-' . rand() . '-' . rand(), 0,30),
            ]);
        }

        return $user;
            
    }
}

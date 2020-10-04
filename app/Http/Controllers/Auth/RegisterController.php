<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\User;

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
            'addr_barangay_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'phone_number' => ['required', 'string', 'max:13', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        $uid = strtoupper(Str::random(5).'-'.Str::random(5).'-'.Str::random(5).'-'.Str::random(5));

        $user = User::create([
            'uid' => $uid,
            'type' => 'resident',
            'name' => $data['name'],
            'birthdate' => $data['birthdate'],
            'gender' => $data['gender'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
            'addr_barangay_id' => $data['addr_barangay_id'],
            'addr_municipality_id' => '015528',
            'addr_province_id' => '0155',
            'addr_region_id' => '01',
            'email_verified_at' => Carbon::now(),
        ]);

        return $user;
    }
}

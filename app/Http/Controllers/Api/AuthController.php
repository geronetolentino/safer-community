<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Carbon\Carbon;

use App\Models\User;
use App\Models\UserInfo;
use App\Models\HealthData;
use App\Models\Establishment;
use App\Models\EstablishmentVisitorLog;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $data = $request->all();

        $validatedData = Validator::make($data,[
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed',
            'addr_municipality_id' => 'required',
            'addr_province_id' => 'required',
            'addr_region_id' => 'required',
            'addr_barangay_id' => 'required',
            'territory' => 'required',
            'type' => 'required',
        ]);

       $pass = ['password' => bcrypt($request->password)];

        if($validatedData->fails()){
            return response(['error' => $validatedData->errors(), 'Validation Error']);
        }

        $user = User::create(array_merge($data,$pass));
        

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([ 'user' => $user, 'access_token' => $accessToken, 'message' => 'Registered Successfully!']);
    }

    public function login(Request $request)
    {
       
        $loginData = request()->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

      

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        if($request->type == 6){
            
            $est_code = Establishment::where('user_id', auth()->user()->id)->pluck('est_code');
        }else{

            $est_code = null;
        }

        return response(['user' => auth()->user(), 'access_token' => $accessToken, 'est_code' => $est_code, 'message' => 'Logged In']);

    }

    //public function scanner($est_code, $poi_id)
    public function scanner(Request $request)
    {
        $est_code = $request->est_code;
        $poi_id = $request->poi_id;

        $entry = false;
        $poi = UserInfo::where('poi_id', $poi_id)->first();
        $health = HealthData::poi($poi_id)->first();

        $check = EstablishmentVisitorLog::poi($poi_id)
        ->estcode($est_code)
        ->cstatus('IN')
        ->today()
        ->first();

        if ($check) {

            $entry = 'OUT';
            $check->status = 'OUT';
            $check->checkout = Carbon::now();
            $check->save();

        } else {

            if ($poi) {
                $entry = 'IN';
                EstablishmentVisitorLog::create([
                    'poi_id' => $poi_id,
                    'scanner_id' => 0,
                    'est_code' => $est_code,
                    'checkin' => Carbon::now(),
                    'checkout' => null,
                    'status' => 'IN',
                ]);
            }
        }
        
        if ($health) {
            $hdata = [
                'test_date' => $health->test_date,
                'test_result' => $health->test_result,
                'remarks' => $health->remarks,
            ];
        } else {
            $hdata = null;
        }

        $data = [
            'est_code' => $est_code,
            'poi' => $poi_id,
            'health' => $hdata?$hdata:null,
            'entry' => $entry
        ];

        return Response::json($data);
    }
}
<?php

namespace App\Http\Controllers\Hospital;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Response;

use App\Models\User;
use App\Models\UserInfo;

class AccountController extends Controller
{
    public function index()
    {
        $data = [
            'pageName' => 'My Profile',
            'navName' => 'My Profile',
        ];

        return view('hospital.account.index')->with($data);
    }

    public function edit()
    {
        $data = [
            'pageName' => 'My Profile - Update',
            'navName' => 'My Profile',
        ];

        return view('hospital.account.edit')->with($data);
    }

    public function save(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->;
        $user->addr_province_id = $request->addr_province_id;
        $user->addr_municipality_id = $request->addr_municipality_id;
        $user->addr_barangay_id = $request->addr_barangay_id;
        $user->address = $request->address;
        $user->save();

        $info = UserInfo::findByUser($user->id);
        $info->phone_number = $phone_number;
        $info->save();

        return Response::json(['true']);
    }

    public function photo(Request $request)
    {
        $file = $request->profile_photo;
        $filename = date('Ymd').'-'.time().rand().'.'.$file->extension();
        $path = '/public/o4uw5tv89ru6oert9nb2c03m9w5093nu4w/';

        $file->storeAs($path, $filename);

        Storage::url($filename);

        $info = UserInfo::findByUser(Auth::user()->id);
        $info->profile_photo = $filename;
        $info->save();

        return $filename;
    }


}
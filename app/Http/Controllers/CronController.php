<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Response;
use Carbon\Carbon;

use App\Models\Notification;
use App\Models\Establishment;
use App\Models\EstablishmentVisitorLog;
use App\Models\UserInfo;
use App\Models\HealthData;

class CronController extends Controller
{

	public function establishmentAutoOut()
	{
        $outs = EstablishmentVisitorLog::where('checkout', null)->where('status','IN')->get();

        foreach ($outs as $key => $log) {

            $hoursAgo = $log->checkin->diffInHours(Carbon::now(), false);
            
            if ($hoursAgo >= 1) {

                $log->checkout = Carbon::now();
                $log->status = 'OUT';
                $log->auto_checkout = TRUE;
                $log->save();

                Notification::create([
                    'user_id' => $log->person->user->id,
                    'title' => 'System Auto Logout',
                    'message' => 'You have been automatically checked out to '.$log->establishment->name.'.',
                    'seen' => FALSE,
                ]);

            }
        }
		
		return Response::json(['STATUS'=>'AUTO OUT']);
	}

	public function sendPhoneNumberVerification()
	{

	}

	public function sendEmailVerification()
	{

	}
 	       
}
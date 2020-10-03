<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

use App\Models\Notification;

trait NotificationTrait
{

	public function notificationPush($data)
	{
		foreach ($data as $key => $value) {
            if ($value['user_id'] != null) {
                Notification::create([
                    'user_id' => $value['user_id'],
                    'title' => $value['title'],
                    'message' => $value['message'],
                    'seen' => 0
                ]);
            }
        }
	}

}
<?php 

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

//use App\Models\UserInfo;

class NotificationComposer
{
    public $notifications;

    public function __construct(){

        $this->notifications = Auth::user()->notifications;
    }
    public function compose (View $view)
    {
        $view->with('notifications', $this->notifications);
    }
}

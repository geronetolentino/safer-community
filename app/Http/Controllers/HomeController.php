<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        return $this->checkpoint('.home');
    }

    public function account()
    {
        return $this->checkpoint('.account');
    }

    public function checkpoint($controller)
    {

        if (Auth::user()->type == 'resident') {

            $to = 'rs'.$controller;

        } elseif (Auth::user()->type == 'lgu') {

            $to = 'lgu'.$controller;

        } elseif (Auth::user()->type == 'hci') {

            $to = 'hci'.$controller;

        } 

        return redirect()->route($to);
    }
}

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

        if (Auth::user()->type == 0) {

            $to = 'wa'.$controller;

        } elseif (Auth::user()->type == 1) {

            $to = 'pa'.$controller;

        } elseif (Auth::user()->type == 2) {

            $to = 'ma'.$controller;

        } elseif (Auth::user()->type == 3){

            $to = 'br'.$controller;

        } elseif (Auth::user()->type == 4){

            $to = 'rs'.$controller;

        } elseif (Auth::user()->type == 5){

            $to = 'hp'.$controller;

        }
        elseif (Auth::user()->type == 6){

            $to = 'es'.$controller;

        }
        elseif (Auth::user()->type == 7){

            $to = 'tr'.$controller;

        }

        return redirect()->route($to);
    }
}

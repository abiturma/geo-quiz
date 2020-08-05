<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function home()
    {
        if(auth()->check()) {
            return view('game');
        }

        return view('welcome');
    }


}

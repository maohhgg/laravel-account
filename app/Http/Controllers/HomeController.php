<?php

namespace App\Http\Controllers;

use App\Turnover;
use App\Config;

class HomeController extends Controller
{

    public function index()
    {
        $results = Turnover::where('user_id',auth()->user()->id)->select('history','created_at')->get();
        return view('home.pages.home',compact('results'));
    }

    public function recharge()
    {
        $results = Config::get('recharge');
        return view('home.pages.recharge',compact('results'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Turnover;

class HomeController extends Controller
{
    public $module = 'home';
    public function index()
    {
        $results = Turnover::where('user_id',auth()->user()->id)->select('history','created_at')->get();
        return view('home.pages.home',compact('results'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Turnover;
use Illuminate\View\View;

class HomeController extends Controller
{
    public string $module = 'home';

    public function index(): View
    {
        $results = Turnover::where('user_id',auth()->user()->id)->select('history','created_at')->get();
        return view('home.pages.home',compact('results'));
    }
}

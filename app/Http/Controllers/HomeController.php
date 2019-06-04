<?php

namespace App\Http\Controllers;

use App\Action;
use App\Turnover;
use App\Config;
use App\Type;

class HomeController extends Controller
{

    public function index()
    {
        $temp = 0;
        $results = [];
        $ts = Turnover::where('user_id', auth()->user()->id)->orderBy('created_at')->get()->toArray();

        foreach ($ts as $t) {
            $temp = Type::turnover($temp, $t['data'], Action::find($t['type_id'])->type->action);
            $results[] = [
                'created_at' => "{$t['created_at']}",
                'history' => "{$temp}"];
        }
//        dd($results);
        return view('home.pages.home', compact('results'));
    }

    public function recharge()
    {
        $results = Config::get('recharge');
        return view('home.pages.recharge.recharge', compact('results'));
    }
}

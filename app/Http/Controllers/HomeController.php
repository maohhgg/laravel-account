<?php

namespace App\Http\Controllers;

use App\Action;
use App\RechargeOrder;
use App\Turnover;
use App\Config;
use App\Type;
use App\User;

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
        if (Config::get('RECHARGE') == 0) return redirect('/');
        $results = Config::get('recharge');
        return view('home.pages.recharge.recharge', compact('results'));
    }

    public function display()
    {
        if (Config::get('RECHARGE') == 0) return redirect('/');
        $items = [
            'order' => '订单号',
            'data' => '金额',
            'is_cancel' => '状态',
            'created_at' => '创建日期'];

        $user = User::find(auth()->user()->id);
        if (is_null($user)) return redirect()->back();

        $r = RechargeOrder::where('user_id', $user->id);
        $results = $r->orderBy('id', 'desc')->Paginate(15);

        return view('home.pages.recharge.display', compact('results', 'items'));
    }
}

<?php


namespace App\Http\Controllers;


use App\Turnover;
use Illuminate\Support\Facades\Route;

class DataController extends Controller
{
    public $module = 'history';

    public function history()
    {
        $items = [
            'data' => '金额(元)',
            'type' => '消息',
            'history' => '变更后余额(元)',
            'created_at' => '日期'];

        $results = Turnover::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->Paginate(15);
        return view('home.pages.data.turnover', compact('items', 'results'));
    }

}
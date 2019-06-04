<?php


namespace App\Http\Controllers;


use App\Collect;
use App\Turnover;

class DataController extends Controller
{

    public function history()
    {
        $items = [
            'data' => '金额(元)',
            'type' => '消息',
            'created_at' => '日期'];

        $results = Turnover::where('user_id', auth()->user()->id)->orderBy('created_at')->Paginate(30);
        return view('home.pages.data.turnover', compact('items', 'results'));
    }

    public function collect()
    {
        $items = [
            'data' => '金额(元)',
            'created_at' => '日期'];
        $id = auth()->user()->id;
        $online_results = Collect::where([['user_id', $id], ['is_online', 1]])->orderBy('id', 'desc')->Paginate(15, ['*'], 'oPage');
        $results = Collect::where([['user_id', $id], ['is_online', 0]])->orderBy('id', 'desc')->Paginate(15, ['*'], 'lPage');
        return view('home.pages.data.collect', compact('items', 'results', 'online_results'));
    }

}
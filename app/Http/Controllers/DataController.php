<?php


namespace App\Http\Controllers;


use App\Action;
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

        $results = Turnover::query()->where('user_id', auth()->user()->id)->orderBy('created_at')->Paginate($this->paginate);
        return view('home.pages.data.turnover', compact('items', 'results'));
    }

    public function collect()
    {
        $items = [
            'data' => '金额(元)',
            'created_at' => '日期'];
        $id = auth()->user()->id;
        $online_results = Turnover::query()
            ->where([['user_id', $id], ['type_id', Action::ONLINE]])
            ->orderBy('created_at', 'desc')
            ->Paginate($this->paginate, ['*'], 'oPage');

        $results = Turnover::query()
            ->where([['user_id', $id],  ['type_id', Action::OFFLINE]])
            ->orderBy('created_at', 'desc')
            ->Paginate($this->paginate, ['*'], 'lPage');

        return view('home.pages.data.collect', compact('items', 'results', 'online_results'));
    }

}
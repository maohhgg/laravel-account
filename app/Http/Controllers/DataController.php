<?php


namespace App\Http\Controllers;


use App\Models\Turnover;
use Illuminate\View\View;

class DataController extends Controller
{
    public string $module = 'history';

    public function history():View
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

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
            'created_at' => '日期',
            'type' => '类型',
            'data' => '交易金额(元)',
            'extend_tax' => '费率',
            'third_tax' => '第三方手续费(元)',
            'true_data' => '手续费总计(元)',
            'history' => '余额(元)',
        ];

        $results = Turnover::where('user_id', '=', auth()->user()->id)
            ->orderBy('id', 'desc')
            ->Paginate(15);

        return view('home.pages.data.turnover', compact('items', 'results'));
    }

}

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
            'type' => '类型',
            'deal' => '交易方式',
            'other' => '其他费用',
            'extend_data' => '其他费用金额',
            'extend_tax' => '费率',
            'true_data' => '到账金额',
            'history' => '变更后余额(元)',
            'created_at' => '日期'
        ];

        $results = Turnover::where([['user_id', auth()->user()->id], ['parent_id', null]])
            ->orderBy('id', 'desc')
            ->Paginate(15);

        return view('home.pages.data.turnover', compact('items', 'results'));
    }

}

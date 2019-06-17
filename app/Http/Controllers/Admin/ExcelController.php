<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrderExport;
use App\Exports\TurnoverExport;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{

    /**
     * @param Request $request
     * @return
     * @throws ValidationException
     */
    public function backup(Request $request)
    {
        $this->validate($request, [
            'database' => 'string'
        ]);

        switch ($request->input('database')){
            case 'users':
                $export = UsersExport::class;
                $name = '全部用户';
                break;
            case 'recharge_orders':
                $export = OrderExport::class;
                $name = '充值记录';
                break;
            case 'turnovers':
                $export = TurnoverExport::class;
                $name = '交易数据';
                break;
            default:
                $export = null;
                break;
        }

        return Excel::download(new $export, $name.'.csv');

    }
}

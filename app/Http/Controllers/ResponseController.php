<?php


namespace App\Http\Controllers;

use App\Config;
use App\Library\Recharge;
use App\Library\RechargeUtil;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;


class ResponseController extends BaseController
{
    /**
     * @param Request $request
     * @return void
     */
    public function body(Request $request)
    {
        $data = $request->input();

        $fp = fopen('request.txt', 'w');
        fwrite($fp, json_encode($data));
        fclose($fp);

        if (count($data) < 1 || !RechargeUtil::ValidSign($data, Config::get('APP_KEY'))) {
            return redirect('/');
        }

        Recharge::response($data['cusorderid'], $data['trxstatus'], $data['trxamt']);
    }
}
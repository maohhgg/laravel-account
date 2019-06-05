<?php


namespace App\Http\Controllers;

use App\Config;
use App\Library\Recharge;
use App\Library\RechargeUtil;
use App\RechargeOrder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class NobodyController extends BaseController
{
    public function success(Request $request)
    {
        $data = $request->input();
        $fp = fopen('success1.txt', 'w');
        fwrite($fp, json_encode($data));
        fclose($fp);

        if (count($data) < 1 && !RechargeUtil::ValidSign($data, Config::get('APPKEY'))) {return redirect('/');}

        $r = RechargeOrder::query()->where('order' ,$data['cusorderid'])->first();

        if ($data['trxstatus'] == "0000") {
            if($r->turn_id == 0){
                $turn_id = Recharge::saveStatus($r, $data['trxamt']);
                $r->update([
                    'is_cancel' => Recharge::SUCCESS,
                    'turn_id' => $turn_id,
                ]);
            }
        } else {
            if (in_array($data['trxstatus'], array_keys(Recharge::Code))) {
                $r->update(['is_cancel' => Recharge::NORESULTS]);
            } else {
                $r->update(['is_cancel' => Recharge::UNKOWN]);
            }
        }
    }
}
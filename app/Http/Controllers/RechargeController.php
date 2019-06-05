<?php


namespace App\Http\Controllers;


use App\Action;
use App\Config;
use App\Library\Order;
use App\Library\Recharge;
use App\Library\RechargeUtil;
use App\RechargeOrder;
use Illuminate\Http\Request;

class RechargeController extends Controller
{
    public function submit(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric|exists:users,id',
            'pay_number' => 'required|numeric|min:0.01|max:9999999999'
        ]);
        $data = [
            'goods' => Order::goods(),
            'goods_inf' => Action::find(3)->name,
            'order' => Order::recharge(),
            'turn_order' =>  Order::order(),
            'user_id' => $request->input('id'),
            'pay_number' => $request->input('pay_number'),
            'is_cancel' => Recharge::PROCESS
        ];
        RechargeOrder::create($data);
        // 订单保存结束

        // 渲染新页面和数据
        $re = Recharge::bind([
            'order' => $data['order'],
            'number' => $data['pay_number'] * 100,    // 只有提交给支付平台的金额需要 * 100
            'goodsId' => $data['goods'],
            'goodsInf' => $data['goods_inf']
        ])->setReturl(route('recharge.success', ['token' => base64_encode($data['order'])]))
            ->setNotifyurl(route('recharge.results'))
            ->setAppKey(Config::get('CUSID'), Config::get('APPID'));
        $params = $re->toArray();
        $params['sign'] = $re->sign(Config::get('APPKEY'));
        $url = Recharge::orderSubmitUri;

        ksort($params);
        return view('home.pages.recharge.confirm', compact('params','url'));
    }

    public function success(Request $request, $token = null)
    {
        if (!$token) return redirect('/');
        $r = RechargeOrder::where('order', base64_decode($token))->first();
        $data = $request->input();

        if (count($data) < 1 && !RechargeUtil::ValidSign($data, Config::get('APPKEY'))) {
            return redirect('/');
        }

        if ($data['trxstatus'] == "0000") {
            if($r->turn_id == 0){
                $turn_id = Recharge::saveStatus($r, $data['trxamt']);
                $r->update([
                    'is_cancel' => Recharge::SUCCESS,
                    'turn_id' => $turn_id,
                    'pay_number' => $data['trxamt'],
                ]);
            }

            $results = [
                'code' => 200,
                'message' => Recharge::Code[$data['trxstatus']]
            ];
        } else {
            if (in_array($data['trxstatus'], array_keys(Recharge::Code))) {
                $results = [
                    'code' => 400,
                    'message' => Recharge::Code[$data['trxstatus']]
                ];
            } else {
                $results = [
                    'code' => 404,
                    'message' => '充值平台无响应，请稍后！'
                ];
            }
        }
        return view('home.pages.recharge.success', compact('results'));

    }

}
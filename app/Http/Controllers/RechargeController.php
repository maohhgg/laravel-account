<?php


namespace App\Http\Controllers;


use App\Action;
use App\Config;
use App\Library\Order;
use App\Library\Recharge;
use App\Library\RechargeUtil;
use App\RechargeOrder;
use App\Turnover;
use App\User;
use Illuminate\Http\Request;

class RechargeController extends Controller
{
    const SUCCESS = 0;
    const CANCEL = 1;
    const NORESULTS = 2;
    const UNKOWN = 3;
    const PROCESS = 4;


    public $statusCode = [
        '0000' => '交易成功',
        '2000' => '交易处理中',
        '2008' => '交易处理中',
        '3044' => '交易超时',
        '3008' => '余额不足',
        '3999' => '交易失败'
    ];

    public function submit(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric|exists:users,id',
            'pay_number' => 'required|numeric|min:0.01|max:9999999999'
        ]);
        $data = [
            'goods' => Order::goods(),
            'goods_inf' => Action::find(3)->name,
            'order' => Order::order(),
            'user_id' => $request->input('id'),
            'pay_number' => $request->input('pay_number'),
            'is_cancel' => self::PROCESS
        ];
        $re = Recharge::bind([
            'order' => $data['order'],
            'number' => $data['pay_number'],
            'goodsId' => $data['goods'],
            'goodsInf' => $data['goods_inf']
        ])->setReturl(route('recharge.success', ['token' => base64_encode($data['order'])]))
            ->setNotifyurl(route('recharge.results'))
            ->setAppKey(Config::get('CUSID'), Config::get('APPID'));
        $params = $re->toArray();
        $params['sign'] = $re->sign(Config::get('APPKEY'));
        $url = Recharge::orderSubmitUri;

        $r = RechargeOrder::create($data);
//        dd($params);
//        if(is_null($r))return redirect()->back();

        return view('home.pages.recharge.confirm', compact('params','url'));
    }

    public function success(Request $request, $token = null)
    {
        if (!$token) return redirect('/');
        $r = RechargeOrder::where('order', base64_decode($token))->first();
        $data = $request->input();
        $fp = fopen('success.txt', 'w');
        fwrite($fp, json_encode($data));
        fclose($fp);

        if (count($data) < 1 && !RechargeUtil::ValidSign($data, Config::get('APPKEY'))) {
            return redirect('/');
        }

        if ($data['trxstatus'] == "0000") {
            $turn_id = $this->saveStatus($r, $data['trxamt']);

            $r->update([
                'is_cancel' => self::SUCCESS,
                'turn_id' => $turn_id,
                'pay_number' => $data['trxamt'],
            ]);

            $results = [
                'code' => 200,
                'message' => $this->statusCode[$data['trxstatus']]
            ];
        } else {
            if (in_array($data['trxstatus'], array_keys($this->statusCode))) {
                $results = [
                    'code' => 400,
                    'message' => $this->statusCode[$data['trxstatus']]
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

    protected function saveStatus(RechargeOrder $rechargeOrder, $data)
    {
        $action = Action::find(3)->type->action;
        User::saveToUser($rechargeOrder->user_id, $rechargeOrder->pay_number, $action);
        $t = Turnover::create([
            'data' => $data,
            'user_id' => $rechargeOrder->user_id,
            'type_id' => 3,
            'order' => $rechargeOrder->order_id,
            'description' => ' --- 用户自己操作',
            'created_at' => $rechargeOrder->created_at,
        ]);
        return $t ? $t->id : null;
    }

    public function results(Request $request)
    {
        $data = $request->input();
        $fp = fopen('success.txt', 'w');
        fwrite($fp, json_encode($data));
        fclose($fp);
        if (count($data) < 1 && !RechargeUtil::ValidSign($data, Config::get('APPKEY'))) {
            return redirect('/');
        }
        $r = RechargeOrder::where(['order', $data['cusorderid'],['is_cancel' ]])->first();

        if ($data['trxstatus'] == "0000") {
            $turn_id = $this->saveStatus($r, $data['trxamt']);
            $r->update([
                'is_cancel' => self::SUCCESS,
                'turn_id' => $turn_id,
                'pay_number' => $data['trxamt'],
            ]);
        } else {
            if (in_array($data['trxstatus'], array_keys($this->statusCode))) {
                $r->update(['is_cancel' => self::NORESULTS]);
            } else {
                $r->update(['is_cancel' => self::UNKOWN]);
            }
        }
    }
}
<?php


namespace App\Http\Controllers;


use App\Action;
use App\Config;
use App\Library\Order;
use App\Library\Recharge;
use App\Library\RechargeUtil;
use App\RechargeOrder;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RechargeController extends Controller
{
    private $mark;  // 判断是否启用在线充值功能

    public function __construct()
    {
        parent::__construct();
        $this->mark = Config::get('RECHARGE_STAT');
    }

    /**
     *   order confirm and submit to [ ? ]
     * @param Request $request
     * @return Factory|RedirectResponse|Redirector|View
     * @throws ValidationException
     */
    public function submit(Request $request)
    {
        if ($this->mark == 0) return redirect('/');
        $this->validate($request, [
            'id' => 'required|numeric|exists:users,id',
            'pay_number' => 'required|numeric|min:0.01|max:9999999999'
        ]);
        $data = [
            'goods' => Order::goods(),  // 充值订单号  *当前无意义*
            'goods_inf' => Action::query()->find(Action::RECHARGE)->name,  // 充值的名字
            'order' => Order::recharge(),    // 充值订单号
            'turn_order' => Order::order(),
            'user_id' => $request->input('id'),
            'pay_number' => $request->input('pay_number'),
            'is_cancel' => Recharge::PROCESS
        ];
        RechargeOrder::query()->create($data);
        // 订单保存结束

        return $this->render($data);
    }


    /**
     *  no pay money order restart pay
     * @param null $order
     * @return Factory|View
     */
    public function restartPay($order = null){
        if(!$order) redirect()->back();
        $data = RechargeOrder::query()->where('order',$order)->first()->toArray();
        return $this->render($data);
    }

    protected function render(array  $data)
    {
        $money = $data['pay_number'];
        // 渲染新页面和数据
        $re = Recharge::bind([
            'order' => $data['order'],
            'number' => $data['pay_number'] * 100,    // 前端提交单位 （元）只有提交给支付平台（分）的金额需要 * 100
            'goodsId' => $data['goods'],
            'goodsInf' => $data['goods_inf']
        ])->setReturl(route('recharge.success', ['token' => base64_encode($data['order'])]))
            ->setNotifyurl(route('recharge.results'))
            ->setAppKey(Config::get('CUS_ID'), Config::get('APP_ID'));
        $params = $re->toArray();
        $params['sign'] = $re->sign(Config::get('APP_KEY'));
        $url = Recharge::orderSubmitUri;

        ksort($params);
        return view('home.pages.recharge.confirm', compact('params', 'money','url'));
    }


    /**
     *  url [Recharge->returl] action
     *
     * @param Request $request
     * @param null $token
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function success(Request $request, $token = null)
    {
        if ($this->mark == 0 && !$token) return redirect('/');
        $r = RechargeOrder::query()->where('order', base64_decode($token))->first();
        $data = $request->input();

        if (count($data) < 1 || !RechargeUtil::ValidSign($data, Config::get('APP_KEY'))) {
            return redirect('/');
        }

        if ($data['trxstatus'] == "0000") {
            if ($r->turn_id == 0) {
                $turn_id = Recharge::saveStatus($r, $data['trxamt']);
                $r->update([
                    'is_cancel' => Recharge::SUCCESS,
                    'turn_id' => $turn_id
                ]);
            }

            $results = ['code' => 200, 'message' => Recharge::Code[$data['trxstatus']]];

        } else {

            if (in_array($data['trxstatus'], array_keys(Recharge::Code))) {
                $results = ['code' => 400, 'message' => Recharge::Code[$data['trxstatus']]];
            } else {
                $results = ['code' => 404, 'message' => '充值平台无响应，请稍后！'];
            }
        }

        return view('home.pages.recharge.success', compact('results'));
    }

}
<?php


namespace App\Http\Controllers;


use App\Action;
use App\Config;
use App\Order;
use App\Library\OrderNumber;
use App\Library\Recharge;
use App\Library\RechargeUtil;
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
        switch ($request->input('pay_number')) {
            case '5000.00':
                $type = Action::RECHARGE_GOLD;
                break;
            case '10000.00':
                $type = Action::RECHARGE_PLATINUM;
                break;
            case '20000.00':
                $type = Action::RECHARGE_DIAMOND;
                break;
            default:
                $type = Action::RECHARGE;
                break;
        }
        $data = [
            'goods' => $type,  // 商品号
            'goods_inf' => Action::query()->find($type)->name,  // 充值的名字
            'order' => OrderNumber::recharge(),    // 充值订单号
            'turn_order' => OrderNumber::order(),
            'user_id' => $request->input('id'),
            'pay_number' => $request->input('pay_number'),
            'order_status_id' => Recharge::PROCESS
        ];
        Order::query()->create($data);
        // 订单保存结束

        return view('home.pages.recharge.confirm')->with([
            'params' => Recharge::bind($data),
            'url'=> Recharge::orderSubmitUri
        ]);
    }


    /**
     *  no pay money order restart pay
     * @param null $order
     * @return Factory|View
     */
    public function restartPay($order = null)
    {
        if (!$order) redirect()->back();
        $data = Order::query()->where('order', $order)->first()->toArray();
        return view('home.pages.recharge.confirm')->with([
            'params' => Recharge::bind($data),
            'url'=> Recharge::orderSubmitUri
        ]);
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

        $data = $request->input();
        $fp = fopen('success.txt', 'w');
        fwrite($fp, json_encode($data));
        fclose($fp);

        if (count($data) < 1 || !RechargeUtil::ValidSign($data, Config::get('APP_KEY'))) {
            return redirect('/');
        }

        $results = Recharge::response(base64_decode($token), $data['trxstatus'], $data['trxamt']);

        return view('home.pages.recharge.success', compact('results'));
    }

}
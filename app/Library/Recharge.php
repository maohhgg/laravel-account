<?php


namespace App\Library;

use App\Action;
use App\Config;
use App\Order;
use App\Turnover;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Recharge
{

    const orderSubmitUri = 'https://vsp.allinpay.com/apiweb/gateway/pay';
    const orderQueryUri = 'https://vsp.allinpaygd.com/apiweb/gateway/query';
    const orderRefund = 'https://vsptest.allinpaygd.com/apiweb/gateway/refund';

    const SUCCESS = 1;
    const CANCEL = 2;
    const PROCESS = 3;
    const FAIL = 4;

    const Code = [
        '0000' => '交易成功',
        '2000' => '交易处理中',
        '2008' => '交易处理中',
        '3044' => '交易超时',
        '3008' => '余额不足',
        '3999' => '交易失败'
    ];


    public $cusid;
    public $appid;
    public $charset;
    public $orderid;  // 订单号
    public $trxamt;  //支付金额
    public $goodsid;  //商品号
    public $goodsinf;   //商品描述信息
    public $returl;   // 页面跳转同步通知页面路径
    public $notifyurl;  // 服务器异步通知页面路径
    public $validtime;  //有效时间
    public $gateid;  // 支付银行
    public $randomstr;


    /**
     * Recharge constructor.
     * @param string $orderId
     * @param int $number
     * @param string $goodsId
     * @param string $goodsInfo
     */
    private function __construct($orderId, $number, $goodsId, $goodsInfo)
    {
        $this->orderid = $orderId;
        $this->trxamt = $number;
        $this->goodsid = $goodsId;
        $this->goodsinf = $goodsInfo;
        $this->validtime = 15;
        $this->gateid = '';
        $this->charset = 'UTF-8';
        $this->randomstr = $orderId;
    }

    /**
     * set user show return url
     * @param string $url
     * @return $this
     */
    public function setRetUrl($url)
    {
        $this->returl = $url;
        return $this;
    }


    /**
     * set server asynchronous url
     * @param string $url
     * @return $this
     */
    public function setNotifyUrl($url)
    {
        $this->notifyurl = $url;
        return $this;
    }

    public function setAppKey($key, $AppId)
    {
        $this->cusid = $key;
        $this->appid = $AppId;
        return $this;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }


    /**
     * @param string $AppKey
     * @return string
     */
    public function sign($AppKey)
    {
        return RechargeUtil::SignArray($this->toArray(), $AppKey);//签名
    }

    /**
     * @param Model $order
     * @param int $amount
     * @return int
     */
    private static function saveTurnover(Model $order, int $amount)
    {
        $action = Action::query()->find(3)->type->action;

        if ($order->turn_id) {
            $t = Turnover::query()->find($order->turn_id);
            if ($t->data != $amount) {
                User::recoveryUser($t, $action);
                User::saveToUser($order->user_id, $amount, $action);
                $t->data = $amount;
                $t->save();
            }
        } else {
            $t = Turnover::query()->create([
                'data' => $amount,
                'user_id' => $order->user_id,
                'type_id' => $order->goods,
                'order' => $order->turn_order,
                'description' => '',
                'created_at' => $order->created_at,
            ]);
            User::saveToUser($order->user_id, $amount, $action);
        }

        return $t->id;
    }


    public static function bind(array $array)
    {
        $recharge = new Recharge(
            $array['order'],
            $array['pay_number'] * 100,
            $array['goods'],
            $array['goods_inf']);

        $recharge->setReturl(route('recharge.success', ['token' => base64_encode($array['order'])]))
            ->setNotifyUrl(route('recharge.results'))
            ->setAppKey(Config::get('CUS_ID'), Config::get('APP_ID'));

        $params = $recharge->toArray();
        $params['sign'] = $recharge->sign(Config::get('APP_KEY'));
        ksort($params);
        return $params;
    }

    /**
     * @param $token
     * @param $code
     * @param $orderAmount
     * @return array
     */
    public static function response($token, $code, $orderAmount)
    {
        $order = Order::query()->where('order', $token)->first();

        $orderAmount = floatval($orderAmount / 100); // 单位是（分） 数据库保存的是（元） 需要 / 100
        $status = 200;
        $message = self::Code[$code];

        switch ($message) {
            case '交易成功':
                if($order->order_status_id != self::SUCCESS){
                    $order->turn_id = self::saveTurnover($order, $orderAmount);
                    $order->order_status_id = self::SUCCESS;
                    if ($order->pay_number != $orderAmount) $order->pay_number = $orderAmount;
                    $order->save();
                }
                break;
            default:
                $status = 400;
                break;
        }
        return ['code' => $status, 'message' => $message];
    }

    /**
     * @param $token
     * @param $code
     * @param $orderAmount
     * @return array
     */
    public static function query($token)
    {

    }

    /**
     * @param $token
     * @param $code
     * @param $orderAmount
     * @return array
     */
    public static function refund($token)
    {

    }
}
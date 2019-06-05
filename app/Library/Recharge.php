<?php


namespace App\Library;

use App\Action;
use App\RechargeOrder;
use App\Turnover;
use App\User;

class Recharge
{

    const orderSubmitUri = 'https://vsp.allinpay.com/apiweb/gateway/pay';
    const orderQueryUri = 'https://vsp.allinpaygd.com/apiweb/gateway/query';
    const orderRefund = 'https://vsptest.allinpaygd.com/apiweb/gateway/refund';

    const SUCCESS = 0;
    const CANCEL = 1;
    const NORESULTS = 2;
    const UNKOWN = 3;
    const PROCESS = 4;

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


    public static function bind(array $array)
    {
        return new Recharge($array['order'], $array['number'], $array['goodsId'], $array['goodsInf']);
    }

    private function __construct($orderId, $number, $goodsId, $goodsInf)
    {
        $this->orderid = $orderId;
        $this->trxamt = $number;
        $this->goodsid = $goodsId;
        $this->goodsinf = $goodsInf;
        $this->validtime = 15;
        $this->gateid = '';
        $this->charset = 'UTF-8';
        $this->randomstr = $orderId;
    }

    public function setReturl($url)
    {
        $this->returl = $url;
        return $this;
    }

    public function setNotifyurl($url)
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


    public function sign($AppKey)
    {
        return RechargeUtil::SignArray($this->toArray(), $AppKey);//签名
    }

    public static function saveStatus(RechargeOrder $rechargeOrder, $data)
    {
        $action = Action::find(3)->type->action;
        User::saveToUser($rechargeOrder->user_id, $rechargeOrder->pay_number, $action);
        $t = Turnover::create([
            'data' => $data,
            'user_id' => $rechargeOrder->user_id,
            'type_id' => 3,
            'order' => $rechargeOrder->turn_order,
            'description' => '',
            'created_at' => $rechargeOrder->created_at,
        ]);
        return $t ? $t->id : null;
    }
}
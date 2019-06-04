<?php


namespace App\Library;

class Recharge
{

    const orderSubmitUri = '//test.allinpaygd.com/apiweb/gateway/pay';
    const orderQueryUri = '//test.allinpaygd.com/apiweb/gateway/query';
    const orderRefund = '//test.allinpaygd.com/apiweb/gateway/refund';

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

}
<?php

namespace App;

use App\Library\Recharge;
use Carbon\Carbon;

class Order extends BaseModel
{
    protected $fillable = ['user_id', 'turn_id', 'turn_order', 'order', 'goods', 'goods_inf', 'pay_number', 'order_status_id'];
    public $table = 'recharge_orders';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id')->select('id', 'name');
    }

    public function turnover()
    {
        return $this->hasOne('App\Turnover', 'id','turn_id')->select('id', 'order');
    }


    /**
     * 订单状态
     */
    public function orderStatus()
    {
        // 将超时订单取消
        if ($this->order_status_id == Recharge::PROCESS){
            if (abs(time() - strtotime($this->created_at)) > 900) {
                $this->updated_at = Carbon::parse(strtotime($this->created_at) + 900)->toDateTimeString();
                $this->order_status_id = Recharge::CANCEL;
                $this->save();
            }
        }
        return $this->hasOne('App\OrderStatus', 'id','order_status_id')
            ->select('id', 'sign', 'label');
    }
}

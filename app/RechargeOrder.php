<?php

namespace App;

use App\Library\Recharge;

class RechargeOrder extends BaseModel
{
    protected $fillable = ['user_id', 'turn_id', 'turn_order', 'order', 'goods', 'goods_inf', 'pay_number', 'is_cancel'];

    protected $appends = ['status'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id')->select('id', 'name');
    }

    public function turnover()
    {
        return $this->hasOne('App\Turnover', 'id','turn_id')->select('id', 'order');
    }

    public function getStatusAttribute()
    {
        $result = '等待支付系统确认';
        switch ($this->is_cancel) {
            case Recharge::PROCESS:
                if (abs(time() - strtotime($this->created_at)) > 900) {
                    $this->update(['is_cancel' => Recharge::CANCEL]);
                    $result = '已取消';
                } else {
                    $result = '等待支付';
                }
                break;
            case Recharge::CANCEL:
                $result = '已取消';
                break;
            case Recharge::SUCCESS:
                $result = '完成';
                break;
        }
        return $result;
    }
}

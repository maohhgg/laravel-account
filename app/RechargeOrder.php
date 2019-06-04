<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RechargeOrder extends Model
{
    protected $fillable = ['user_id','turn_id', 'order', 'goods', 'goods_inf', 'pay_number', 'is_cancel', 'created_at'];

    public $timestamps = false;
}

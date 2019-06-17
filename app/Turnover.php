<?php

namespace App;


class Turnover extends BaseModel
{
    protected $fillable = ['user_id', 'type_id', 'data', 'description', 'created_at', 'order', 'is_recharge'];

    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Action', 'type_id');
    }

    public function hasOrder()
    {
        return $this->hasOne('App\RechargeOrder', 'turn_id', 'id');
    }

}

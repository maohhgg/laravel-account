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
        return $this->hasOne('App\Order', 'turn_id', 'id');
    }

    public function collect()
    {
        return $this->hasOne('App\Collect', 'turn_id', 'id');
    }
}

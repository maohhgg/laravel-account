<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turnover extends Model
{
    protected $fillable = ['user_id', 'type_id', 'data', 'description', 'created_at', 'order', 'is_recharge'];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

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

    public function collect()
    {
        return $this->hasOne('App\Collect', 'turn_id', 'id');
    }
}

<?php

namespace App;


class Collect extends BaseModel
{
    protected $fillable = [
        'total', 'is_online', 'user_id', 'turn_id', 'order'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id')->select('id', 'name');
    }

    public function type()
    {
        return $this->belongsTo('App\Action', 'is_online')->select('id', 'name');
    }

    public function turnover()
    {
        return $this->belongsTo('App\Turnover', 'turn_id', 'id')
            ->select('id', 'data', 'created_at');
    }
}

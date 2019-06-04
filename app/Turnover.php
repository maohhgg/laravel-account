<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turnover extends Model
{
    protected $fillable = ['user_id', 'type_id', 'data', 'description', 'created_at', 'order'];

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

    public function pre()
    {
        return $this->belongsTo(self::class, 'pre_id');
    }

    public function next()
    {
        return $this->belongsTo(self::class, 'id','pre_id');
    }

}

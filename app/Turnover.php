<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turnover extends Model
{
    protected $fillable = ['user_id', 'type_id', 'data', 'history', 'description'];

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
        return $this->belongsTo('App\ChangeAction', 'type_id');
    }
}

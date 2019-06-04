<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    protected $fillable = [
        'data', 'is_online', 'user_id', 'created_at','turn_id'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id')->select('id', 'name');
    }
}

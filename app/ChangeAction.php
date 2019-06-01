<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class ChangeAction extends model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'change_type_id',
    ];

    public function type()
    {
        return $this->belongsTo('App\ChangeType', 'change_type_id');
    }

    public function turnover()
    {
        return $this->hasMany('App\Turnover', 'type_id');
    }
}
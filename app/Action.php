<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Action extends model
{
    public $timestamps = false;
    public $table = 'change_actions';

    protected $fillable = [
        'name', 'change_type_id', 'can_delete'
    ];

    public function type()
    {
        return $this->belongsTo('App\Type', 'change_type_id');
    }

    public function turnover()
    {
        return $this->hasMany('App\Turnover', 'type_id');
    }
}
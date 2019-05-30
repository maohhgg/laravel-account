<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class ChangeAction extends model
{
    public $timestamps = false;

    public function type()
    {
        return $this->belongsTo('App\ChangeType', 'change_type_id');
    }
}
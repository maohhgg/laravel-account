<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class ChangeType extends model
{

    public $timestamps = false;

    public function actions(){
        return $this->hasMany('App\ChangeAction','change_type_id');
    }
}
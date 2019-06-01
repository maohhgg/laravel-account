<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class ChangeType extends model
{
    const INCOME = 'income';
    const EXPENDITURE = 'expenditure';

    public $timestamps = false;

    public function actions()
    {
        return $this->hasMany('App\ChangeAction', 'change_type_id');
    }


}
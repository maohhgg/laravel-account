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

    public static function reverse(string $action)
    {
        return $action == self::INCOME ? self::EXPENDITURE : self::INCOME;
    }

    public static function turnover($balance, $data, $action)
    {
        return $action == self::INCOME ? self::income($balance, $data) : self::expenditure($balance, $data);
    }

    public static function income($balance, $data){
        return $balance = $balance + $data;
    }

    public static function expenditure($balance, $data){
        return $balance = $balance - $data;
    }
}
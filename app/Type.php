<?php


namespace App;


class Type extends BaseModel
{
    const INCOME = 'income';
    const EXPENDITURE = 'expenditure';

    public $timestamps = false;
    public $table = 'change_types';

    public function actions()
    {
        return $this->hasMany('App\Action', 'change_type_id');
    }

    public static function reverse(string $action)
    {
        return $action == self::INCOME ? self::EXPENDITURE : self::INCOME;
    }

    public static function turnover($balance, $data, $action)
    {
        return $action == self::INCOME ? self::income($balance, $data) : self::expenditure($balance, $data);
    }

    public static function is_push($action)
    {
        return $action === self::INCOME;
    }

    public static function income($balance, $data){
        return $balance = $balance + $data;
    }

    public static function expenditure($balance, $data){
        return $balance = $balance - $data;
    }

    public static function getTypeArray(){
        $changeTypes = $temp = [];
        $types = self::query()->where('id', '>', '0')->select('id', 'name')->with('actions')->get()->toArray();

        foreach ($types as $item) {
            foreach ($item['actions'] as $value) {
                $temp[(string)$value['id']] = $value['name'];
            }
            $changeTypes[$item['name']] = $temp;$temp = [];
        }
        return $changeTypes;
    }
}
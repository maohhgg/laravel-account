<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends model
{
    const INCOME = 'income';
    const EXPENDITURE = 'expenditure';

    public $timestamps = false;
    public $table = 'change_types';

    public function actions(): HasMany
    {
        return $this->hasMany('App\Models\Action', 'change_type_id');
    }

    static function reverse(string $action): string
    {
        return $action == self::INCOME ? self::EXPENDITURE : self::INCOME;
    }

    static function turnover($balance, $data, $action): float
    {
        return $action == self::INCOME ? self::income($balance, $data) : self::expenditure($balance, $data);
    }

    static function income($balance, $data): float
    {
        return $balance + $data;
    }

    static function expenditure($balance, $data): float
    {
        return $balance - $data;
    }

    static function getTypeArray(): array
    {
        $changeTypes = $temp = [];
        $types = self::where('id', '>', '0')->select('id', 'name')->with('actions')->get()->toArray();

        foreach ($types as $item) {
            foreach ($item['actions'] as $value) {
                $temp[(string)$value['id']] = $value['name'];
            }
            $changeTypes[$item['name']] = $temp;$temp = [];
        }

        return $changeTypes;
    }
}

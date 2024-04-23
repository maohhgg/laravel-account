<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeType extends model
{
    use HasFactory;

    public $timestamps = false;

    const ADD_CREDIT = 1;
    const CHARGES = 2;
    const CREDIT_CARD = 3;

    protected $fillable = [
        'name',
        'is_increase'
    ];


    static function turnover($balance, $data, $action): float
    {
        return $action ? self::income($balance, $data) : self::expenditure($balance, $data);
    }

    static function income($balance, $data): float
    {
        return $balance + $data;
    }

    static function expenditure($balance, $data): float
    {
        return $balance - $data;
    }

    static function getTypes(): array
    {
        $result = [];
        $t = self::where('visible', true)->select('id', 'name')->orderBy('id', 'desc')->get();

        foreach ($t as $i) {
            $result[$i->id] = $i->name;
        }

        return $result;
    }

    static function getTypesToshow(): array
    {
        $a = $b = [];

        $t = self::where('is_trade', '=', 1)->select('id', 'name')->get();
        foreach ($t as $i) {
            $a[$i->id] = $i->name;
        }
        $t = self::where('is_trade','=', 0)->select('id', 'name')->get();
        foreach ($t as $i) {
            $b[$i->id] = $i->name;
        }

        return [
            '交易类型' => $b,
            '余额可变操作' => $a,
        ];
    }
}

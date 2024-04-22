<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeType extends model
{
    use HasFactory;
    const INCOME = 'income';
    const EXPENDITURE = 'expenditure';

    protected $fillable = [
        'name',
        'is_increase'
    ];


    static function reverse(string $action): string
    {
        return $action == self::INCOME ? self::EXPENDITURE : self::INCOME;
    }

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
        $income = $expenditure = [];
        $t = self::where('id', '>', '0')->select('id', 'name', 'is_increase')->get();

        foreach ($t as $i) {
            $i->is_increase ? $income[$i->id] = $i->name : $expenditure[$i->id] = $i->name;
        }

        return [
            '收入方式' => $income,
            '支出方式' => $expenditure
        ];
    }
}

<?php


namespace App\Library;


class Order
{
    public static function goods()
    {
        return 'GNO' . self::generate();
    }

    public static function collect()
    {
        return 'CNO' . self::generate();
    }

    public static function order()
    {
        return 'ONO' . self::generate();
    }

    protected static function generate()
    {
        return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))),0,8);
    }
}
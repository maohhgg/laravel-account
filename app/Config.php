<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'admin_configs';

    static public function get($string)
    {
        $c = self::where('key',$string)->first();
        return is_null($c) ?  null : $c->value;
    }
}

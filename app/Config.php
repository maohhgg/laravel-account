<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = ['value'];

    public $timestamps = false;

    protected $table = 'admin_configs';

    /**
     * @param $key
     * @return string|null
     */
    static public function get($key)
    {
        $c = self::where('key', $key)->first();
        return is_null($c) ? null : $c->value;
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    static public function set($key, $value)
    {
        $c = self::where('key', $key)->first();
        return $c != $value ? self::where('key', $key)->update(['value' => $value]) : false;
    }
}

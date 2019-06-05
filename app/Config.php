<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{

    const SERVER_NAME = 'SERVER_NAME';

    const CUS_ID = 'CUS_ID';
    const APP_ID = 'APP_ID';
    const APP_KEY = 'APP_KEY';

    const RECHARGE_STAT = 'RECHARGE_STAT';

    const COLLECT_OFFLINE = 'COLLECT_OFFLINE';
    const COLLECT_ONLINE = 'COLLECT_ONLINE';

    const PAGINATE = 'PAGINATE';


    protected $fillable = ['value'];

    public $timestamps = false;

    protected $table = 'admin_configs';

    protected $appends = ['name'];

    /**
     * @param $key
     * @return string|null
     */
    static public function get($key)
    {
        $c = self::where('key', $key)->first();
        return is_null($c) ? null : $c->value;
    }

    static public function getAll($key)
    {
        $c = self::where('key', $key)->select('key', 'value', 'label')->first();
        return is_null($c) ? null : $c;
    }

    public function getNameAttribute()
    {
        if($this->key == self::COLLECT_ONLINE) return Action::find(Action::ONLINE)->name;
        else if($this->key == self::COLLECT_OFFLINE) return Action::find(Action::OFFLINE)->name;
        else return $this->label;
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

<?php

namespace App;

/**
 * @property mixed key
 * @property mixed value
 * @property string label
 */
class Config extends BaseModel
{

    const SERVER_NAME = 'SERVER_NAME';

    const CUS_ID = 'CUS_ID';
    const APP_ID = 'APP_ID';
    const APP_KEY = 'APP_KEY';

    const RECHARGE_STAT = 'RECHARGE_STAT';

    const RECORD_ICP = 'RECORD_ICP';

    const PAGINATE = 'PAGINATE';


    protected $fillable = ['value'];

    public $timestamps = false;

    protected $table = 'admin_configs';

    protected $appends = ['name'];

    private static $config = [];

    /**
     * @param string $key
     * @param bool|string $attribute
     * @param bool $all
     * @return string|null|Config
     */
    static public function get($key, $all = false, $attribute = false)
    {
        if (!in_array($key, array_keys(self::$config))) {
            $config = self::query()->where('key', $key)->select('key', 'value', 'label')->first();
            if (is_null($config)) return null;
            self::$config[$key] = $config;
        }

        return $all == true ?
            self::$config[$key] :
            ($attribute === false ? self::$config[$key]->value : self::$config[$key]->getAttribute($attribute));
    }

    public function getNameAttribute()
    {
        return $this->label;
    }


    /**
     * @param $key
     * @param $value
     * @return bool
     */
    static public function set($key, $value)
    {
        if ($value != self::get($key)) {
            $config = self::query()->where('key', $key)->update(['value' => $value]);
            if (!is_null($config)) {
                self::$config[$key]->value = $value;
                return true;
            }
        }
        return false;
    }
}

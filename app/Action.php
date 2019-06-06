<?php


namespace App;


class Action extends BaseModel
{
    // 固定的3个类型id
    const OFFLINE = 1;  // 线下交易汇总
    const ONLINE = 2;   // 在线交易汇总
    const RECHARGE = 3; // 充值

    public $timestamps = false;
    public $table = 'change_actions';

    protected $fillable = [
        'name', 'change_type_id', 'can_delete'
    ];

    public function type()
    {
        return $this->belongsTo('App\Type', 'change_type_id');
    }

    public function turnover()
    {
        return $this->hasMany('App\Turnover', 'type_id');
    }

    public static function getCollect()
    {
        return [
            self::OFFLINE => self::query()->find(self::OFFLINE)->name,
            self::ONLINE => self::query()->find(self::ONLINE)->name
        ];
    }

    public static function collectInterest()
    {
        return [
            self::OFFLINE => (float)Config::get(Config::COLLECT_OFFLINE),
            self::ONLINE => (float)Config::get(Config::COLLECT_ONLINE)
        ];
//        [Action::OFFLINE] = 0.0047;
//        [Action::ONLINE] = 0.0042;
    }


}
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * according to turnover data change user balance and total
     *
     * @param int $userId
     * @param float $amount
     * @param string $action
     */
    public static function saveToUser(int $userId, float $amount, string $action)
    {
        $user = self::find($userId);
        $user->balance = Type::turnover($user->balance, $amount, $action);
        $user->save();
    }


    /**
     * recovery user balance and total
     *
     * @param Turnover $turnover
     * @param string $action
     */
    public static  function recoveryUser(Turnover $turnover, string $action)
    {
        $user = self::find($turnover->user_id);
        $user->balance = Type::turnover($user->balance, $turnover->data, Type::reverse($action));
        $user->save();
    }
}

<?php

namespace App;

use App\Library\ValidateError;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property mixed email
 * @property mixed phone
 */
class User extends Authenticatable
{
    const DEFAULT_EMAIL = 'example@example.org';
    const DEFAULT_PHONE = '13800000000';

    use Notifiable,ValidateError;

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
        $user = self::query()->find($userId);
        $user->balance = Type::turnover($user->balance, $amount, $action);
        $user->save();
    }

    public function emailDefault(){
        return $this->email == self::DEFAULT_EMAIL;
    }

    public function phoneDefault(){
        return $this->phone == self::DEFAULT_PHONE;
    }

    /**
     * recovery user balance and total
     *
     * @param Turnover $turnover
     * @param string $action
     */
    public static function recoveryUser(Turnover $turnover, string $action)
    {
        $user = self::query()->find($turnover->user_id);
        $user->balance = Type::turnover($user->balance, $turnover->data, Type::reverse($action));
        $user->save();
    }
}

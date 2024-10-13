<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Turnover extends Model
{
    protected $fillable = [
        'user_id',
        'type_id',
        'data',
        'third_tax',
        'history',
        'description',
        'tax',
        'tax_id',
        'tax_rate',
        'created_at'
    ];

    public $timestamps = false;

    public static function boot(): void
    {
        parent::boot();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function taxType(): BelongsTo
    {
        return $this->belongsTo('App\Models\TradeType', 'tax_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo('App\Models\TradeType', 'type_id');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }
}

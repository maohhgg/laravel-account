<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Turnover extends Model
{
    protected $fillable = [
        'user_id',
        'type_id',
        'data',
        'history',
        'description',
        'tax',
        'tax_id',
        'tax_rate',
    ];

    public $timestamps = false;

    public static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Turnover extends Model
{
    protected $fillable = ['user_id', 'type_id', 'data', 'history', 'description'];

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

    public function type(): BelongsTo
    {
        return $this->belongsTo('App\Models\Action', 'type_id');
    }
}

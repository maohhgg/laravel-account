<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Action extends model
{
    public $timestamps = false;
    public $table = 'change_actions';

    protected $fillable = [
        'name',
        'change_type_id',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo('App\Models\Type', 'change_type_id');
    }

    public function turnover(): HasMany
    {
        return $this->hasMany('App\Models\Turnover', 'type_id');
    }
}

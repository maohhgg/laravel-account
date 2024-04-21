<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function children():HasMany
    {
        return $this->hasMany(
            self::class,
            'parent_id',
            'id'
        );
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            self::class,
            'parent_id'
        );
    }
}

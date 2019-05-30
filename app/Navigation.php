<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    public $timestamps = false;

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

}

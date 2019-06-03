<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    public $timestamps = false;

    public function children()
    {
        return $this
            ->hasMany(self::class, 'parent_nav','id')
            ->where('is_nav' ,1)
            ->select('action','icon','name','url','parent_nav');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_nav','id')
            ->select('action','icon','name','url','id');
    }

}

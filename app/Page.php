<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $timestamps = false;

    public function parent()
    {
        return $this->belongsTo('App\Navigation','navigation_id');
    }

}

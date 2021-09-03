<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    protected $guarded = [];

    function cities()
    {
        return $this->hasMany(City::class);
    }
}

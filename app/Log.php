<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $guarded = [];

    public function loggable()
    {
        return $this->morphTo();
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }
}

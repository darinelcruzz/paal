<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retainer extends Model
{
    protected $guarded = [];

    function client()
    {
        return $this->belongsTo(Client::class);
    }

    function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    function movements()
    {
        return $this->morphMany(Movement::class, 'movable');
    }
}

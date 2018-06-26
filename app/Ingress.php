<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingress extends Model
{
    protected $fillable = ['client_id', 'bought_at', 'products', 'company', 'amount', 'status'];

    function client()
    {
    	return $this->belongsTo(Client::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = ['social', 'name', 'rfc', 'address', 'phone', 'email',
    	'contact', 'type', 'city', 'postcode', 'company', 'amount', 'bills', 'status'];
}

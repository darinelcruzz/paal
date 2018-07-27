<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'address', 'postcode', 'city', 'state', 'rfc', 'credit', 'company'];
}

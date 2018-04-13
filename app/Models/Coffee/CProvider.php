<?php

namespace App\Models\Coffee;

use Illuminate\Database\Eloquent\Model;

class CProvider extends Model
{
    protected $fillable = ['social', 'name', 'rfc', 'address', 'phone', 'email', 'contact'];
}

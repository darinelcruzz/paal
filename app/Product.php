<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
	use Notifiable;
	
    protected $fillable = [
    	'description', 'wholesale_price', 'retail_price', 'wholesale_quantity', 'code', 
    	'barcode', 'family', 'iva', 'is_variable', 'dollars', 'is_summable', 'category', 'company'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $guarded = [];
	
    function user()
    {
    	return $this->belongsTo(User::class);
    }
    
    function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    function movements()
    {
        return $this->morphMany(Movement::class, 'movable');
    }

    function getColorAttribute()
    {
    	$colors = ['pagada' => 'success', 'cancelada' => 'danger', 'pendiente' => 'warning'];

    	return in_array($this->status, $colors) ? $colors[$this->status]: 'default';
    }

    function getIsCompletedAttribute()
    {
        return $this->purchases->sum('amount') == $this->amount;
    }

    function getAlreadyMovementsAttribute()
    {
        $already_purchased = Movement::where('movable_type', 'App\Purchase')
            ->whereIn('movable_id', $this->purchases->pluck('id'))
            ->pluck('quantity', 'product_id');

        // dd($already_purchased->keys(), $already_purchased->values());

        return Movement::where('movable_type', 'App\Order')
            ->where('movable_id', $this->id)
            ->whereIn('product_id', $already_purchased->keys())
            ->get()
            ->map(function ($item)  use ($already_purchased){
                $item->quantity = $already_purchased[$item->product_id];
                return $item;
            });
    }

    function getNotYetMovementsAttribute()
    {
        $already_purchased = Movement::where('movable_type', 'App\Purchase')
            ->whereIn('movable_id', $this->purchases->pluck('id'))
            ->pluck('quantity', 'product_id');

        return Movement::where('movable_type', 'App\Order')
            ->where('movable_id', $this->id)
            ->when($already_purchased->count() == 0, function ($query) use ($already_purchased) {
                $query->whereNotIn('product_id', $already_purchased->keys());
            }, function ($query) use ($already_purchased) {
                $query->whereIn('product_id', $already_purchased->keys());
            })
            ->get()
            ->map(function ($item)  use ($already_purchased){
                if ($already_purchased->count() != 0) {
                    $item->quantity -= $already_purchased[$item->product_id];
                }
                return $item;
            });
    }
}

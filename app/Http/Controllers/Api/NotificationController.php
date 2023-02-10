<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\{Shipping, Egress, Ingress, Task};
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    function shippings($company)
    {
        $user = auth()->user();
    	return Shipping::whereStatus('pendiente')
	        ->whereHas('ingress', function ($query) use ($user) {
	            $query->whereStoreId($user->store_id);
	        })
	        ->count();
    }

    function egresses($company)
    {
        $user = auth()->user();
    	return Egress::whereStoreId($user->store_id)
	        ->where('status', '!=', 'pagado')
	        ->where('status', '!=', 'eliminado')
	        ->whereBetween('expiration', [now(), now()->addDays(3)])
	        ->count();
    }

    function numbers($company)
    {
        $user = auth()->user();
        return 0;
    	return Ingress::all()
	        ->whereStoreId($user->store_id)
	        ->where('are_serial_numbers_missing', true)
	        ->count();
    }

    function tasks($company)
    {
        $user = auth()->user();
    	return Task::whereStoreId($user->store_id)
    		->when(auth()->user()->id > 2, function ($query) {
    			$query->where('assigned_to', auth()->user()->id);
    		})
    		->where('status', 'pendiente')
    		->count();
    }

    function expired($company)
    {
        $user = auth()->user();
    	return Task::whereStoreId($user->store_id)
    		->when($user->id > 2, function ($query) use ($user) {
    			$query->where('assigned_to', $user->id);
    		})
    		->where('status', 'vencida')
    		->count();
    }
}

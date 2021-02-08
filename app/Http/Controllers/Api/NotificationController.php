<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\{Shipping, Egress, Ingress, Task};
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    function shippings($company)
    {
    	return Shipping::whereStatus('pendiente')
	        ->whereHas('ingress', function ($query) use ($company) {
	            $query->where('company', $company);
	        })
	        ->count();
    }

    function egresses($company)
    {
    	return Egress::whereCompany($company)
	        ->where('status', '!=', 'pagado')
	        ->where('status', '!=', 'eliminado')
	        ->whereBetween('expiration', [now(), now()->addDays(3)])
	        ->count();
    }

    function numbers($company)
    {
    	return Ingress::all()
	        ->where('company', $company)
	        ->where('are_serial_numbers_missing', true)
	        ->count();
    }

    function tasks($company)
    {
    	return Task::where('company', $company)
    		->where('assigned_to', auth()->user()->id)
    		->where('status', 'pendiente')
    		->count();
    }
}

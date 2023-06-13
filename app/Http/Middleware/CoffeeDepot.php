<?php

namespace App\Http\Middleware;

use Closure;

class CoffeeDepot
{
    function handle($request, Closure $next)
    {
        if ($request->user()->company_id == 2 || $request->user()->level <= 0) {
            return $next($request);
        }

        return redirect('/');
    }
}

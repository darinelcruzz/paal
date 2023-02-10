<?php

namespace App\Http\Middleware;

use Closure;

class CoffeeDepot
{
    function handle($request, Closure $next)
    {
        if ($request->user()->company_id == 2 || $request->user()->company == 'owner') {
            return $next($request);
        }

        return redirect('/');
    }
}

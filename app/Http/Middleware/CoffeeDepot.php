<?php

namespace App\Http\Middleware;

use Closure;

class CoffeeDepot
{
    function handle($request, Closure $next)
    {
        if ($request->user()->company == 'paal+' || $request->user()->company == 'coffee' || $request->user()->company == 'both' || $request->user()->company == 'owner') {
            return $next($request);
        }

        return redirect('/');
    }
}

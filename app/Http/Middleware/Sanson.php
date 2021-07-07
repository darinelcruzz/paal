<?php

namespace App\Http\Middleware;

use Closure;

class Sanson
{
    function handle($request, Closure $next)
    {
        if ($request->user()->company == 'paal+' || $request->user()->company == 'sanson' || $request->user()->company == 'owner' || $request->user()->company == 'coffee') {
            return $next($request);
        }

        return redirect('/');
    }
}

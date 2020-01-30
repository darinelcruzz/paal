<?php

namespace App\Http\Middleware;

use Closure;

class CoffeeDepot
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->company == 'coffee' || $request->user()->company == 'both' || $request->user()->company == 'owner') {
            return $next($request);
        }

        return redirect('/');
    }
}

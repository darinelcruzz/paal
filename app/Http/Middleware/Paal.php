<?php

namespace App\Http\Middleware;

use Closure;

class Paal
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
        if ($request->user()->company == 'paal') {
            return $next($request);
        }

        return redirect('/');
    }
}

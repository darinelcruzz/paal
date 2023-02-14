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
        if ($request->user()->store_id == 1 || $request->user()->level == 0) {
            return $next($request);
        }

        return redirect('/');
    }
}

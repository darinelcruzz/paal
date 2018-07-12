<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    public function handle($request, Closure $next)
    {
        if ($request->user()->company == 'owner') {
            return $next($request);
        }

        return back();
    }
}

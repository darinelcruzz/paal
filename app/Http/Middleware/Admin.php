<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    public function handle($request, Closure $next)
    {
        if ($request->user()->level == 0) {
            return $next($request);
        }

        return back();
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class MailboxesEtc
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
        if ($request->user()->company <= 1 || $request->user()->store_id == 3) {
            return $next($request);
        }

        return redirect('/');
    }
}

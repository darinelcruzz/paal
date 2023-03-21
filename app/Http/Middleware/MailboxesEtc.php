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
        if ($request->user()->store_id == 3 || $request->user()->level == 0) {
            return $next($request);
        }

        return redirect('/');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ProvincialAdministrator
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
        if (Auth::user()->type == 1) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}

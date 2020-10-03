<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Establishment
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
        if (Auth::user()->type == 6) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}

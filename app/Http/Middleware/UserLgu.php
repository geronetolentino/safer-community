<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserLgu
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
        if (Auth::user()->type == 'lgu') {
            return $next($request);
        }

        return redirect()->route('home');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class DirectorAuthenticate
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
        if (!auth()->guard('director')->check()) {
            return redirect(route('director.login'));
        }
        return $next($request);
    }
}

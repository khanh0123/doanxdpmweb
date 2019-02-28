<?php

namespace App\Http\Middleware;

use Closure;

class WriterUser
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
        if (!session()->has('permission') || !session()->get('permission')->canWrite) {
            
            return abort(403);
            
        }
        return $next($request);
    }
}

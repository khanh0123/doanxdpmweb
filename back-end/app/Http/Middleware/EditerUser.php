<?php

namespace App\Http\Middleware;

use Closure;

class EditerUser
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
        if (!session()->has('permission') || !session()->get('permission')->canWrite || !session()->get('permission')->canUpdate) {
            
            return response('Unauthorized.', 403);
            
        }
        return $next($request);
    }
}

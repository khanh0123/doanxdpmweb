<?php

namespace App\Http\Middleware;

use Closure;

class EditerDelete
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
        if (!session()->has('permission') || !session()->get('permission')->canDelete || !session()->get('permission')->canUpdate || !session()->get('permission')->canWrite) {
            
            return response('Unauthorized.', 403);
            
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class SupperAdmin
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
        if (!session()->has('permission') || !session()->get('permission')->canWrite || !session()->get('permission')->canUpdate ||  !session()->get('permission')->canDelete ||  !session()->get('permission')->isAdmin) {
            
            abort(403, 'Something went wrong');            
        }
        return $next($request);
    }
}

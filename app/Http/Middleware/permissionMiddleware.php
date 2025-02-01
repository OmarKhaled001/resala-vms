<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class permissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission, $guard = null)
    {
        if(auth($guard)->user()->hasPermission($permission)){
            return $next($request);
        } else {
            return abort(403,'لا يوجد صلاحية');
        }

    }
}

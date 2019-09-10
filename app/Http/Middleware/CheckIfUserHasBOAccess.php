<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfUserHasBOAccess
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
        if(\Auth::user()->hasPermissionTo('backoffice access')){
            return $next($request);
        }else{
            abort(403, 'You haven\'t access to backoffice.');
        }
    }
}

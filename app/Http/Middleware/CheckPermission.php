<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $module, $canAccessEditOwnProfile = false)
    {
        switch ($request->route()->getName()){
            case "{$module}.index":
                if(\Auth::user()->hasPermissionTo("list {$module}")){
                    return $next($request);
                }else{
                    abort(403, "You haven't Permission to see {$module} list");
                }
                break;
            case "{$module}.update":
            case "{$module}.edit":
                if(\Auth::user()->hasPermissionTo("edit {$module}")
                        //Check if the user can edit his own profile
                   || ($canAccessEditOwnProfile && (\Auth::user()->id == $request->route()->parameter($module)))
                    ){
                    return $next($request);
                }else{
                    abort(403, "You haven't Permission to edit {$module}");
                }
                break;
            case "{$module}.create":
            case "{$module}.store":
                if(\Auth::user()->hasPermissionTo("add {$module}")){
                    return $next($request);
                }else{
                    abort(403, "You haven't Permission to edit {$module}");
                }
                break;
            case "{$module}.destroy":
                if(\Auth::user()->hasPermissionTo("destroy {$module}")){
                    return $next($request);
                }else{
                    abort(403, "You haven't Permission to see {$module} list");
                }
                break;
        }
    }
}

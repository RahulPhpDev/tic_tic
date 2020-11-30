<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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

        if(Auth::check())
        {
            if(Auth::user()->isAdmin())
            {
                return $next($request);
            }
        }
        Auth::logout();
        return redirect('/');

//
//        if (! Auth::check() )
//        {
//            abort(401, 'not authorized');
//        }
//          if(!Auth::user()->isAdmin())
//          {
//              abort(401, 'not authorized');
//          }
//
////        if (! $request->user()->hasRole($role)) {
////            abort(401, 'This action is unauthorized.');
////        }
////        return $next($request);
//        return $next($request);
    }
}

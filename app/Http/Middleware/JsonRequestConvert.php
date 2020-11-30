<?php

namespace App\Http\Middleware;

use Closure;

class JsonRequestConvert
{

    const PERMITTED_METHOD = ['POST', 'PUT', 'GET'];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $status = ($request->getContent() !== '' ) ? true : false;
      if ( $status &&  in_array( $request->getMethod() , self::PERMITTED_METHOD) )

      {
        $request->merge(
           (array) json_decode( $request->getContent() , true)
        );
        
      }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class Gudang
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

        if(\Auth::user()->role != 'gudang')
        {
            Session::flash('info', 'You do not have permissions to perform this action');
            return redirect()->back();
        }
        return $next($request);
        
    }
}

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
    public function handle($request, Closure $next, $guard = "admin")
    {
        $role = Auth::guard('admin')->user()->role;
        //$g = auth()->guard($guard)->check();
        //dd($g);
        
        if(auth()->guard($guard)->check()){
            return $next($request);
        }
        else{
            return redirect('/admin/login');
            //return back();
        }
        
        
    }
}

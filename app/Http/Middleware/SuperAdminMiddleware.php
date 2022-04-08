<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
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
        // $role = Auth::guard('admin')->user()->role;
        // //dd($role);
        
        // if(auth()->guard($guard)->check() && $role == 'superAdmin'){
        //     //return redirect('/admin/login');
        //     //abort(403, "You do not have permission to access the Admin Control Panel. If you believe this is an error please contact the admin who set your account up for you.");
        //     return $next($request);
        // }
        // else{
        //     return redirect('/admin/login');
        // }
        
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        if(Auth::user() == null){
            return redirect('login')->with('error',"You don't have admin access.");
        } elseif(auth()->user()->is_admin == 1){
            return $next($request);
        }
        return redirect('login')->with('error',"You don't have admin access.");
    }
}

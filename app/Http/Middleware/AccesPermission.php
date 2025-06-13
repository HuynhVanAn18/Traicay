<?php

namespace App\Http\Middleware;
use Auth;
Use Illuminate\Support\Facades\Route;
use Closure;
use Illuminate\Http\Request;

class AccesPermission
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
        if (Auth::user()->hasRole('admin')) {
            return $next($request);
        }
        return redirect('/dashboard');
    }
}

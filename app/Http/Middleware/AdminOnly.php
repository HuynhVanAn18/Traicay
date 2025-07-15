<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin')) {
            return redirect('/admin')->with('message', 'Bạn không có quyền truy cập');
        }
        return $next($request);
    }
}

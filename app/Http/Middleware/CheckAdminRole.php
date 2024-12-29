<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user() && auth()->user()->role !== 'admin') {
            return redirect('/'); // Перенаправляем на главную страницу, если это не админ
        }

        return $next($request);
    }
}

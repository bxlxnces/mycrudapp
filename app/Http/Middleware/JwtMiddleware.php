<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Проверка токена
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token is invalid or expired'], 401);
        }

        // Добавление аутентифицированного пользователя в запрос
        auth()->login($user);

        return $next($request);
    }
}

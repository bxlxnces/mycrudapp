<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // Регистрация нового пользователя
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Генерация токена для пользователя
        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    // Авторизация пользователя
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only('email', 'password');

        try {
            // Попытка создать токен
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Получаем данные текущего пользователя
            $user = JWTAuth::user();

            // Возвращаем токен и данные пользователя
            return response()->json([
                'token' => $token,
                'user' => $user,
            ]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    // Получение информации о текущем пользователе
    public function user(Request $request)
    {
        return response()->json(auth()->user());
    }

    // Логика выхода пользователя (удаление токена)
    public function logout(Request $request)
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}

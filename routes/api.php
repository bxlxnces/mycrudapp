<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;

// Регистрация и логин
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('user', [AuthController::class, 'user'])->middleware('auth:api');
Route::post('/orders', [OrderController::class, 'store']);

// Добавляем маршрут для выхода
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

// Ресурсы сотрудников с JWT аутентификацией
Route::middleware('jwt.auth')->apiResource('/employee', EmployeeController::class);

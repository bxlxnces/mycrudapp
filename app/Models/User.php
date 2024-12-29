<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject; // Подключаем интерфейс JWTSubject
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements JWTSubject // Реализуем интерфейс JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Добавили поле для роли
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the identifier for the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Возвращаем ключ пользователя, который будет использоваться в JWT
    }

    /**
     * Get custom claims for the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role, // Добавляем роль в полезную нагрузку JWT
        ];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Это позволяет Laravel автоматически хэшировать пароль при создании
        ];
    }

    /**
     * Проверка, является ли пользователь администратором.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin'; // Проверка роли пользователя
    }
}

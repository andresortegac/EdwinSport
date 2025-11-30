<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->role)) {
                $user->role = 'user';
            }

            if (empty($user->remember_token)) {
                $user->remember_token = Str::random(10);
            }
        });
    }

    // ✅ Dueño (solo el dueño debe tener role developer)
    public function isDeveloper(): bool
    {
        return strtolower($this->role) === 'developer';
    }

    // ✅ Empleados admin + dueño developer pasan
    public function isAdmin(): bool
    {
        return in_array(strtolower($this->role), [
            'admin',
            'superadmin',
            'developer', // ✅ clave para que el dueño no tenga 403
        ]);
    }

    public function isSuperAdmin(): bool
    {
        return strtolower($this->role) === 'superadmin';
    }
}

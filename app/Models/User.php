<?php

namespace App\Models;

// [IMPORTANTE] Esta linha deve estar descomentada:
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// [IMPORTANTE] Adicione "implements MustVerifyEmail" aqui:
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    // ... (o resto do código continua igual)
    protected $fillable = [
        'name',
        'email',
        'password',
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

    // Relação com a lista (mantenha a sua função existente)
    public function list()
    {
        return $this->hasOne(ListModel::class);
    }
}

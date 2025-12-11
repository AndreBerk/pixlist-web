<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPhoto extends Model
{
    use HasFactory;

    protected $fillable = ['list_id', 'photo_path', 'guest_name', 'message', 'is_approved'];

    // Relação com comentários
    public function comments()
    {
        return $this->hasMany(PhotoComment::class);
    }

    // Relação com likes
    public function likes()
    {
        return $this->hasMany(PhotoLike::class);
    }

    // Helper para saber se o usuário atual já deu like
    public function getLikedAttribute()
    {
        return $this->likes()->where('session_id', session()->getId())->exists();
    }
}

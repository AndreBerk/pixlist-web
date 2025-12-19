<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPhoto extends Model
{
    use HasFactory;

    protected $table = 'event_photos';

    protected $fillable = [
        'list_id',
        'photo_path',
        'guest_name',
        'message',
        'is_approved', // Essencial para a moderação funcionar
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    // Relacionamentos
    public function list()
    {
        return $this->belongsTo(ListModel::class);
    }

    public function likes()
    {
        return $this->hasMany(PhotoLike::class);
    }

    public function comments()
    {
        return $this->hasMany(PhotoComment::class);
    }
}

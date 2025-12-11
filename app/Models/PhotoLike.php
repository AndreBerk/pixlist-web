<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoLike extends Model
{
    use HasFactory;

    // Permitir inserção em massa destes campos
    protected $fillable = ['event_photo_id', 'session_id'];

    public function photo()
    {
        return $this->belongsTo(EventPhoto::class, 'event_photo_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoComment extends Model
{
    use HasFactory;

    // Permitir inserção em massa destes campos
    protected $fillable = ['event_photo_id', 'author_name', 'content'];

    public function photo()
    {
        return $this->belongsTo(EventPhoto::class, 'event_photo_id');
    }
}

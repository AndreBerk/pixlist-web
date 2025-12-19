<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListModel extends Model
{
    use HasFactory;

    protected $table = 'lists';

    protected $fillable = [
        'user_id',
        'display_name',
        'event_date',
        'event_type',
        'style',
        'event_location',
        'story',
        'pix_key',
        'cover_photo_url',
        'rsvp_enabled',
        'gallery_enabled',
        'moderation_enabled',
        'meta_goal',
        'roulette_config',
        'plano_pago',
        'plano_expires_at',
        'trial_expires_at',
        'vows_bride',
        'vows_bride_pin',
        'vows_groom',
        'vows_groom_pin',
    ];

    protected $casts = [
        'event_date' => 'date',
        'plano_expires_at' => 'datetime',
        'trial_expires_at' => 'datetime',
        'rsvp_enabled' => 'boolean',
        'gallery_enabled' => 'boolean',
        'moderation_enabled' => 'boolean',
        'roulette_config' => 'array',
    ];

    // ==========================================
    // RELACIONAMENTOS
    // ==========================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(EventPhoto::class, 'list_id');
    }

    public function rsvps()
    {
        return $this->hasMany(Rsvp::class, 'list_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'list_id');
    }

    public function gifts()
    {
        return $this->hasMany(Gift::class, 'list_id');
    }

    // <--- ADICIONE ISTO AQUI
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'list_id');
    }
}

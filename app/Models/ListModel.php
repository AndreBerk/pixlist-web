<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ListModel extends Model
{
    use HasFactory;

    protected $table = 'lists';

    protected $fillable = [
        'user_id',
        'event_type',
        'display_name',
        'event_date',
        'style',
        'meta_goal',
        'cover_photo_url',
        'story',
        'event_location',
        'pix_key',
        'rsvp_enabled',
        'trial_expires_at',
        
        // --- CAMPOS FINANCEIROS IMPORTANTES ---
        'plano_pago',        // Permite marcar como pago
        'plano_expires_at',  // Permite salvar a data de validade (FALTAVA ESTE)
    ];

    /* Relação: Pertence a um Usuário */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /* Relação: Tem Muitos Presentes */
    public function gifts(): HasMany
    {
        return $this->hasMany(Gift::class, 'list_id');
    }

    /* Relação: Tem Muitas Transações (Extrato) */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'list_id');
    }

    /* Relação: Tem Muitas Confirmações de Presença */
    public function rsvps(): HasMany
    {
        return $this->hasMany(Rsvp::class, 'list_id');
    }
}
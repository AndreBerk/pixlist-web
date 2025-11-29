<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Lista de campos que podem ser editados em massa.
     * ADICIONADO: 'is_approved' para permitir a aprovação.
     */
    protected $fillable = [
        'list_id',
        'gift_id',
        'amount',
        'guest_name',
        'guest_message',
        'is_approved', // <--- ESTA LINHA É A SOLUÇÃO
    ];

    /**
     * Relação: A transação pertence a uma Lista
     */
    public function listModel(): BelongsTo
    {
        return $this->belongsTo(ListModel::class, 'list_id');
    }

    // Relação: A transação pertence a um Presente
    public function gift(): BelongsTo
    {
        return $this->belongsTo(Gift::class);
    }
}
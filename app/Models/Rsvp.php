<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rsvp extends Model
{
    use HasFactory;

    // Quais campos podemos preencher em massa
    protected $fillable = [
        'list_id',
        'guest_name',
        'adults',
        'children',
        'contact',
        'status',
    ];

    /**
     * Relação: Esta confirmação (RSVP) "Pertence a" (BelongsTo) uma Lista.
     */
    public function listModel(): BelongsTo
    {
        return $this->belongsTo(ListModel::class, 'list_id');
    }
}

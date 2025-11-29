<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory;

    /**
     * [NOVA LINHA] Força o modelo a usar a tabela 'feedbacks' (plural).
     * Isto resolve o erro "Table 'pixlist.feedback' doesn't exist".
     */
    protected $table = 'feedbacks';

    // Permite a escrita em massa
    protected $fillable = [
        'user_id',
        'rating',
        'message',
    ];

    // Define a relação: um Feedback pertence a um User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

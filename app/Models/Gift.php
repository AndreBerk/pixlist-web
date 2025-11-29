<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gift extends Model
{
    use HasFactory;

    protected $fillable = [
        'list_id',
        'title',
        'description',
        // 'category', // <-- REMOVIDO
        'value',
        'quantity',
        'quantity_paid',
        'image_url',
    ];

    public function listModel(): BelongsTo
    {
        return $this->belongsTo(ListModel::class, 'list_id');
    }
}

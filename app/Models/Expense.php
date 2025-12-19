<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'list_id', 'description', 'category', 'amount',
        'list_id', 'description', 'category', 'payment_method',
        'amount_paid', 'due_date', 'status'
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
    ];

    public function list()
    {
        return $this->belongsTo(ListModel::class);
    }
}

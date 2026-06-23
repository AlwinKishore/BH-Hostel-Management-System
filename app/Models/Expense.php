<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'title', 'category', 'amount', 'date', 
        'paid_to', 'payment_method', 'description', 'status'
    ];

    protected $casts = [
        'date' => 'date',
    ];
}

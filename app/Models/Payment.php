<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'chapa_reference',
        'amount',
        'currency',
        'payment_method',
        'chapa_response',
        'status',
    ];

    protected $casts = [
        'chapa_response' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
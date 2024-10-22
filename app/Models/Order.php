<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $guarded = [];

    protected $casts = [
        'purchase_at' => 'datetime',
        'arrival_at'  => 'datetime',
    ];

    const STATUS = [
        'N' => ['新規','secondary'],
        'P' => ['購入済み','warning'],
        'E' => ['到着','success'],
        'K' => ['保留','secondary'],
    ];

    const RULES = [
        'product_name'  => ['required', 'string', 'max:255'],
        'register_id'   => ['required'],
        'charger_id'    => ['required'],
        'note'          => ['nullable', 'string', 'max:5000'],
    ];
}

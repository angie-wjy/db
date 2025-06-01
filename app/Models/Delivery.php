<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'type',
        'status',
        'resi',
        'orders_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }
}


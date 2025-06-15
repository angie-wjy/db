<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersHasProducts extends Model
{
    use HasFactory;

    protected $table = 'orders_has_products';

    protected $fillable = [
        'products_id',
        'orders_id',
        'quantity',
    ];

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }
}

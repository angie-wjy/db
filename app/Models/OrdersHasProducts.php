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

    public $timestamps = false; // Karena tabel tidak memiliki created_at & updated_at

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

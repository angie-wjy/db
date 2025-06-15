<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersHasBundles extends Model
{
    use HasFactory;

    protected $table = 'orders_has_bundles';

    protected $fillable = [
        'order_id',
        'product_bundling_id',
        'quantity',
        'price'
    ];

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function productBundling()
    {
        return $this->belongsTo(ProductsHasBundles::class, 'product_bundling_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'carts_item';

    protected $fillable = ['cart_id', 'product_id', 'jumlah'];

    public $timestamps = false; // Tidak ada kolom created_at dan updated_at

    public $incrementing = false; // Primary key adalah composite key

    protected $primaryKey = ['cart_id', 'product_id']; // Laravel tidak mendukung composite key langsung

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'carts';

    protected $fillable = [
        'created_date',
        'created_id',
        'updated_id',
        'deleted_id',
        'customer_user_id'
    ];

    protected $dates = ['deleted_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_user_id', 'user_id');
    }

    // cart_item
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'carts_id', 'id');
    }
}

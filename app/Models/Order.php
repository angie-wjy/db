<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'date',
        'total',
        'status',
        'created_id',
        'updated_id',
        'deleted_id',
        'branches_id',
        'customers_id',
        'employees_id'
    ];

    protected $attributes = [
        'status' => 'new',
    ];

    protected $dates = ['deleted_at'];

    public function ship()
    {
        return $this->hasOne(Ship::class, 'orders_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customers_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'user_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'order_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'orders_has_products', 'orders_id', 'products_id')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function orderDetails()
    {
        return $this->hasMany(OrdersHasProducts::class, 'orders_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'code',
        'name',
        'price',
        'description',
        'image',
        'created_id',
        'updated_id',
        'deleted_id',
        'categories_id',
        'product_sizes_id',
        'product_themes_id'
    ];

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    public function size()
    {
        return $this->belongsTo(ProductSize::class, 'product_sizes_id');
    }

    public function theme()
    {
        return $this->belongsTo(ProductTheme::class, 'product_themes_id');
    }

    public function bundles()
    {
        return $this->belongsToMany(Bundle::class, 'products_has_bundles', 'products_id', 'bundles_id')
            ->withPivot('quantity');
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'products_has_branches', 'products_id', 'branches_id')
            ->withPivot('stock');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'orders_has_products', 'products_id', 'orders_id')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}

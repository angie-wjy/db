<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bundle extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bundles';

    protected $fillable = [
        'id',
        'name',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];


    public function productsHasBundles()
    {
        return $this->hasMany(ProductsHasBundles::class, 'bundles_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_has_bundles', 'bundles_id', 'products_id')->withPivot('quantity');
    }
}

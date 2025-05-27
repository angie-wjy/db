<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsHasBundles extends Model
{
    use HasFactory;

    protected $table = 'products_has_bundles';

    public $timestamps = false;
    // protected $primaryKey = null;
    public $incrementing = false;
    // protected $keyType = 'int';

    protected $fillable = [
        'products_id',
        'bundles_id',
        'quantity'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_bundling_has_product', 'product_bundling_id', 'product_id')
            ->withPivot('quantity');
    }

    // public function mainProduct()
    // {
    //     return $this->belongsTo(Product::class, 'product_id');
    // }
}

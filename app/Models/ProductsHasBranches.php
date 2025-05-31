<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsHasBranches extends Model
{
    use HasFactory;

    protected $table = 'products_has_branches';

    public $timestamps = true;
    // protected $primaryKey = null;
    public $incrementing = true;
    // protected $keyType = 'int';

    protected $fillable = [
        'products_id',
        'branches_id',
        'stock'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_has_branches', 'id', 'product_id')
            ->withPivot('stock');
    }

    // public function mainProduct()
    // {
    //     return $this->belongsTo(Product::class, 'product_id');
    // }
}

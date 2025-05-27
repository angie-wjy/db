<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    protected $table = 'product_sizes';
    protected $fillable = ['id','name',];

    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Product::class, 'product_size_id');
    }
}

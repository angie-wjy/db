<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTheme extends Model
{
    protected $table = 'product_themes';

    protected $fillable = ['id', 'name',];

    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Product::class, 'product_theme_id');
    }
}

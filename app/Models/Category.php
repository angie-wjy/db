<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'categories_id');
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($category) {
    //         $category->slug = Str::slug($category->name);
    //     });

    //     static::updating(function ($category) {
    //         $category->slug = Str::slug($category->name);
    //     });
    // }

    // public static function updateSlugs()
    // {
    //     foreach (self::all() as $cat) {
    //         $cat->slug = Str::slug($cat->name);
    //         $cat->save();
    //     }
    // }
}

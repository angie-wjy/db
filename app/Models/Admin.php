<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';

    protected $fillable = ['code', 'user_id'];

    public $timestamps = false;

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

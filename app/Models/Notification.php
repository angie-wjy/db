<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notifications';

    protected $fillable = [
        'message',
        'date',
        'created_id',
        'updated_id',
        'deleted_id'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    protected $dates = ['deleted_at'];
}

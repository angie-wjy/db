<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'branches';

    protected $fillable = [
        'id',
        'mall',
        'address',
        'latitude',
        'longitude',
        'created_id',
        'updated_id',
        'deleted_id'
    ];

    protected $dates = ['deleted_at'];

    public $timestamps = true;

    protected $primaryKey = 'id';

    public $incrementing = false;
}

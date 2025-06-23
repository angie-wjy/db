<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ship extends Model
{
    use SoftDeletes;

    protected $table = 'ships';

    protected $fillable = [
        'type',
        'address',
        'status',
        'resi',
        'orders_id',
        'created_id',
        'updated_id',
        'deleted_id',
    ];

    protected $casts = [
        'type' => 'string',
        'status' => 'string',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_id');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_id');
    }
}

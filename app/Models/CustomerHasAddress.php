<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerHasAddress extends Model
{
    use HasFactory;

    protected $table = 'customer_has_address';

    public $timestamps = true;
    // protected $primaryKey = null;
    public $incrementing = true;
    // protected $keyType = 'int';

    protected $fillable = [
        'customer_id',
        'address'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifPromoUser extends Model
{
    use HasFactory;

    protected $table = 'notifications_has_users';

    protected $fillable = [
        'notifications_id',
        'users_id',
    ];

    public $timestamps = false;

    public function notif()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

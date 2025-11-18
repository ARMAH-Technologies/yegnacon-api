<?php

namespace App\Entities;

use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'type'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'notification_user', 'user_id', 'notification_id')
            ->withPivot('status', 'from_id')->withTimestamps();
    }
}

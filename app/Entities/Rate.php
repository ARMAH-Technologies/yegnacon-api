<?php

namespace App\Entities;

use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Rate extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'rate', 'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'from_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'to_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class,'to_id');
    }
}

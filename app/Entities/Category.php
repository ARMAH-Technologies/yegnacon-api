<?php

namespace App\Entities;

use App\Entities\Traits\CategoryTrait;
use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use CategoryTrait;

    protected $dates = ['deleted_at'];

    public function tender()
    {
        return $this->hasOne(Tender::class, 'category_id');
    }

    public function proformaRequestItems()
    {
        return $this->hasMany(ProformaRequestItem::class, 'category_id');
    }

    public function contractor()
    {
        return $this->belongsToMany(Contractor::class, 'profile_category', 'profile_id', 'category_id')
            ->wherePivot("type", 'Tender')
            ->withTimestamps();
    }
}

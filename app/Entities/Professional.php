<?php

namespace App\Entities;

use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Professional extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
       'professional_title', 'birth_date', 'gender', 'nationality','biography',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tenderCategories()
    {
        return $this->belongsToMany(Category::class, 'profile_category', 'profile_id', 'category_id')
            ->wherePivot("type", 'Tender')
            ->withTimestamps();
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class, 'professional_id');
    }

    public function educations()
    {
        return $this->hasMany(Education::class, 'professional_id');
    }

    public function skills()
    {
        return $this->hasMany(Skill::class, 'professional_id');
    }
}

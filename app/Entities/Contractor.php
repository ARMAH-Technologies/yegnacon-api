<?php

namespace App\Entities;

use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Contractor extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'type', 'level','established_year','description'
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


    public function employees(){
        return $this->hasMany(Employee::class);
    }

    public function leaves(){
        return $this->belongsToMany(Leave::class, 'contractors_leaves', 'leave_id', 'contractor_id')->withPivot('value');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'profile_id');
    }

    public function proformaRequests()
    {
        return $this->hasMany(ProformaRequest::class, 'requester_id');
    }

    public function groups()
    {
        return $this->hasMany(ProformaGroups::class, 'created_by');
    }

}

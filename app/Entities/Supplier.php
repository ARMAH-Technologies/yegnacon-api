<?php

namespace App\Entities;

use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'established_year',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function employees(){
        return $this->hasMany(Employee::class);
    }

    public function leaves(){
        return $this->belongsToMany(Leave::class, 'leaves_suppliers', 'leave_id', 'supplier_id')->withPivot('value');
    }

    public function proformaCategories()
    {
        return $this->belongsToMany(Category::class, 'profile_category', 'profile_id', 'category_id')
            ->wherePivot("type", 'Proforma')
            ->withPivot('type')
            ->withTimestamps();
    }

    public function tenderCategories()
    {
        return $this->belongsToMany(Category::class, 'profile_category', 'profile_id', 'category_id')
            ->wherePivot("type", 'Tender')
            ->withPivot('type')
            ->withTimestamps();
    }

    public function proformaGroups()
    {
        return $this->belongsToMany(ProformaUserGroups::class, 'proforma_user_groups', 'user_id', 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function proformaResponses()
    {
        return $this->hasMany(ProformaResponse::class, 'responder_id');
    }

}

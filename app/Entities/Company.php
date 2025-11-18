<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'email'
    ];

    public function address()
    {
        return $this->hasOne(Address::class, 'item_id');
    }

    public function file()
    {
        return $this->hasOne(File::class, 'item_id');
    }

    public function vacancies()
    {
        return $this->hasMany(Vacancy::class);
    }

    public function tenders()
    {
        return $this->hasMany(Tender::class, 'item_id');
    }

    public function activeProjects()
    {
        return $this->hasMany(ActiveProject::class);
    }


}

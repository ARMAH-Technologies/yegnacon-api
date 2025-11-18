<?php

namespace App\Entities;

use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectOwner extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['type'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function activeProjects()
    {
        return $this->hasMany(ActiveProject::class, 'project_owner_id');
    }
}

<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProformaUserGroups extends Model
{
   use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
    	'id', 'user_id'
    ];

    public function groupId() 
    {
    	return $this->belongsTo(ProformaGroups::class, 'group_id');
    }

    public function userId() 
    {
    	return $this->belongsTo(Supplier::class, 'user_id');
    }
}

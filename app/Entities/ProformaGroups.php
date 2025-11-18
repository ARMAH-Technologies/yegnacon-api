<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProformaGroups extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'type', 'status', 'name'
    ];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'created_by');
    }
}

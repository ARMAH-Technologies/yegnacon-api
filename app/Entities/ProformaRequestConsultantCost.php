<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProformaRequestConsultantCost extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
      'title', 'description', 'type', 'level'
    ];

    public function proformaRequest()
    {
        return $this->belongsTo(ProformaRequest::class, 'proforma_request_id');
    }
}

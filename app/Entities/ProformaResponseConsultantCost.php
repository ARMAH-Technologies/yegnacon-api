<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProformaResponseConsultantCost extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'description'
    ];

    public function proformaResponse()
    {
        return $this->belongsTo(ProformaResponse::class, 'proforma_response_id');
    }
}

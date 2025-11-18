<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProformaResponse extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'validity_date'
    ];

    public function proformaResponseItems()
    {
        return $this->hasMany(ProformaResponseItem::class, 'proforma_response_id');
    }

    public function proformaRequest()
    {
        return $this->belongsTo(ProformaRequest::class, 'proforma_request_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'responder_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'responder_id');
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class, 'responder_id');
    }

    public function contractorAndConsultant()
    {
        return $this->belongsTo(ContractorAndConsultant::class, 'responder_id');
    }

    public function proformaResponseProjectCost()
    {
        return $this->hasMany(ProformaResponseProjectCost::class, 'proforma_response_id');
    }

    public function file()
    {
        return $this->hasOne(File::class, 'item_id');
    }
}

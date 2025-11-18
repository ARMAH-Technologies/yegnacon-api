<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProformaRequest extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
       'type','requester_type', 'status'
    ];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'requester_id');
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class, 'requester_id');
    }

    public function contractorAndConsultant()
    {
        return $this->belongsTo(ContractorAndConsultant::class, 'requester_id');
    }

    public function proformaRequestItems()
    {
        return $this->hasMany(ProformaRequestItem::class, 'proforma_request_id');
    }

    public function proformaRequestProjectCost()
    {
        return $this->hasOne(ProformaRequestProjectCost::class, 'proforma_request_id');
    }

    public function proformaRequestConsultantCost()
    {
        return $this->hasOne(ProformaRequestConsultantCost::class, 'proforma_request_id');
    }

    public function proformaResponses()
    {
        return $this->hasMany(ProformaResponse::class, 'proforma_request_id');
    }

    public function file()
    {
        return $this->hasOne(File::class, 'item_id');
    }

}

<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProformaResponseItem extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'quantity', 'price','unit','delivery_type', 'delivery_date', 'description'
    ];

    public function proformaResponse()
    {
        return $this->belongsTo(ProformaResponse::class, 'proforma_response_id');
    }

    public function proformaRequestItem()
    {
        return $this->belongsTo(ProformaRequestItem::class,'proforma_request_item_id');
    }
}

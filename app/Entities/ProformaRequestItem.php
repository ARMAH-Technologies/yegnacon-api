<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProformaRequestItem extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
      'item_name', 'quantity','unit', 'description'
    ];

    protected $guarded = [
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function proformaRequest()
    {
        return $this->belongsTo(ProformaRequest::class, 'proforma_request_id');
    }

    public function proformaResponseItems()
    {
        return $this->hasMany(ProformaResponseItem::class, 'proforma_request_item_id');
    }

}

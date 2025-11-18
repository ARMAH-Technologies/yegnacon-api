<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
         'file_name'
    ];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class,'item_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'item_id');
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class,'item_id');
    }

    public function projectOwner()
    {
        return $this->belongsTo(ProjectOwner::class,'item_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'item_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'item_id');
    }

    public function activeProject()
    {
        return $this->belongsTo(ActiveProject::class,'item_id');
    }

    public function news()
    {
        return $this->belongsTo(News::class,'item_id');
    }

    public function ProformaResponse()
    {
        return $this->belongsTo(ProformaResponse::class, 'item_id');
    }

    public function ProformaRequest()
    {
        return $this->belongsTo(ProformaRequest::class, 'item_id');
    }
}

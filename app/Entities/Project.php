<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Project extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'category', 'client','description','elapsed_time', 'cost', 'location'
    ];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'profile_id');
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class, 'profile_id');
    }

    public function contractorAndConsultant()
    {
        return $this->belongsTo(ContractorAndConsultant::class, 'profile_id');
    }

    public function file()
    {
        return $this->hasOne(File::class, 'item_id');
    }


    public function scopeSearchByName($query, Request $request){
        if ($request->has('search')){
            $search_key = $request->get("search");
            $query = $query->where("title", "like", "%" . $search_key . "%");
        }
        return $query;
    }

}

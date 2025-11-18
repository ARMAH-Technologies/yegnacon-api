<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Vacancy extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'category', 'contract','education_level','experience',
        'salary','work_place','description','closing_date','status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class,'item_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class,'item_id');
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class, 'item_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'item_id');
    }

    public function scopeSearchByName($query, Request $request){
        if ($request->has('search')){
            $search_key = $request->get("search");
            $query = $query->where("title", "like", "%" . $search_key . "%");
        }
        return $query;
    }

    public function scopeFilterVacancy($query, Request $request){
        $query->filterByField($request);
        $query->filterByLocation($request);
    }

    public function scopeFilterByField($query, Request $request)
    {
        if ($request->has('field')) {
            $search_key = $request->get('field');
            $query = $query->where("category", $search_key);
            return $query;
        }
        return $query;
    }
    public function scopeFilterByLocation($query, Request $request)
    {
        if ($request->has('location')) {
            $search_key = $request->get('location');
            $query = $query->where("work_place", $search_key);
            return $query;
        }
        return $query;
    }
}

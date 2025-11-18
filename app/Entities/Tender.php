<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Tender extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title','category','document_price', 'bid_bond','opening_date',
        'closing_date','description', 'status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class,'item_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class,'item_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'item_id');
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class, 'item_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function scopeSearchByName($query, Request $request){
        if ($request->has('search')){
            $search_key = $request->get("search");
            $query = $query->where("title", "like", "%" . $search_key . "%");
        }
        return $query;
    }

    public function scopeFilterByCategory($query, Request $request)
    {
        if ($request->has('category_id')) {
            $search_key = $request->get('category_id');
            $query = $query->where("category_id", $search_key);
            return $query;
        }
        return $query;
    }

    public function scopeFilterByStatus($query, Request $request)
    {
        if ($request->has('status')) {
            $search_key = $request->get('status');
            $query = $query->where("status", $search_key);
            return $query;
        }
        return $query;
    }

    public function scopeYesterday($query)
    {
        $query = $query->whereDate('created_at', '=', Carbon::yesterday()->toDateString());

        return $query;
    }
}

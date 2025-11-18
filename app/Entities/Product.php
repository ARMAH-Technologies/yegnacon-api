<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Sofa\Eloquence\Eloquence;

class Product extends Model
{
    use SoftDeletes;
    use Eloquence;

    protected $dates = ['deleted_at'];

    protected $fillable = [
         'name', 'category','quantity','unit','price','description'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'item_id');
    }

    public function file()
    {
        return $this->hasOne(File::class, 'item_id');
    }

    public function scopeSearchProduct($query, Request $request){
        if ($request->has('search')){
            return $query->where('name', 'like', '%' . $request->search . '%');
        }
    }

    public function scopeFilterByCategory($query, Request $request)
    {
        if ($request->has('category')){
            $search_key = $request->category;
            return $query->where('category', $search_key);

        }
    }

}

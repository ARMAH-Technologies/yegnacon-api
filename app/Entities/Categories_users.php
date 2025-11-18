<?php
/**
 * Created by PhpStorm.
 * User: yaye
 * Date: 10/3/2016
 * Time: 2:39 PM
 */

namespace App\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Categories_users extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public function categories()
    {
        return $this->belongsToMany(Category::class,'categories_users','user_id','category_id')->withTimestamps();
    }
    public function users()
    {

        return $this->belongsToMany(Category::class,'categories_users','user_id','category_id')->withTimestamps();
    }
}
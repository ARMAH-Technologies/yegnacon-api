<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'description'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class,'news_id');
    }

    public function files()
    {
        return $this->hasMany(File::class,'item_id');
    }
}

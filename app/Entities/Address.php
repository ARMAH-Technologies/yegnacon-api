<?php

namespace App\Entities;

use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Address extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'website', 'phone_number_1', 'phone_number_2','country','city','sub_city', 'house_no',
        'specific_address','latitude','longitude','facebook_link', 'twitter_link', 'linkidin_link',
        'google_link', 'instagram_link', 'item_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'item_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'item_id');
    }
}

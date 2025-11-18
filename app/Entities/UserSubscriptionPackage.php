<?php
/**
 * Created by PhpStorm.
 * User: yido
 * Date: 8/11/16
 * Time: 12:04 PM
 */

namespace App\Entities;

use App\Entities\Traits\UuidForKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubscriptionPackage extends Model
{
    use SoftDeletes;
    use UuidForKey;

    protected $dates = ['deleted_at'];

    protected $fillable = ["package", "duration_in_months", "price"];

    protected $table = "subscription_packages";

    public function subscriptions(){
        return $this->hasMany(UserSubscription::class);
    }



}
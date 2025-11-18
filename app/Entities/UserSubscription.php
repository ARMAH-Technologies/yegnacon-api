<?php
/**
 * Created by PhpStorm.
 * User: yido
 * Date: 8/11/16
 * Time: 11:55 AM
 */

namespace App\Entities;

use App\Entities\Traits\UuidForKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Entities\Users\User;

class UserSubscription extends Model
{
    use SoftDeletes;
    use UuidForKey;


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function package()
    {
        return $this->belongsTo(UserSubscriptionPackage::class, 'subscription_package_id');
    }
    public function salesPerson(){
        return $this->belongsTo(Sales::class, 'sales_id');
    }



}
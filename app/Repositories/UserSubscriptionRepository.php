<?php
/**
 * Created by PhpStorm.
 * User: yido
 * Date: 8/11/16
 * Time: 12:13 PM
 */

namespace App\Repositories;


use App\Entities\Sales;
use App\Entities\UserSubscription;
use Webpatser\Uuid\Uuid;

class UserSubscriptionRepository
{
    public function getAllSubscription($n)
    {
        return UserSubscription::all();
    }
    public function getCurrentUserSubscription($user_id)
    {
        
        return UserSubscription::where('user_id',$user_id)->first();
    }
    public function getAllUserSubscription($user_id)
    {
        return UserSubscription::where('user_id',$user_id)->get();
    }

}
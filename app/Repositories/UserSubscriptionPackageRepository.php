<?php
/**
 * Created by PhpStorm.
 * User: yido
 * Date: 8/11/16
 * Time: 4:14 PM
 */

namespace App\Repositories;

use App\Entities\Sales;
use App\Entities\Users\User;
use App\Entities\UserSubscriptionPackage;
use Webpatser\Uuid\Uuid;

class UserSubscriptionPackageRepository
{
    public function getAllSubscriptionPackageRepositories(){
        return UserSubscriptionPackage::all();
    }
    
}
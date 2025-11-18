<?php
/**
 * Created by PhpStorm.
 * User: yido
 * Date: 8/11/16
 * Time: 4:01 PM
 */

namespace App\Repositories;

use App\Entities\Sales;
use App\Entities\UserSubscription;
use Webpatser\Uuid\Uuid;

class SalesRepository
{
    public function getAllSales(){
        return Sales::all();
    }
    public function getSalesSubscriptions($sales_id,$n){
        return UserSubscription::where(['sales_id'=>$sales_id])->latest()->paginate($n);
    }
}
<?php
namespace App\Transformers;

use App\Entities\UserSubscriptionPackage;
use League\Fractal\TransformerAbstract;

class UserSubscriptionPackageTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

    public function transform(UserSubscriptionPackage $userSubscriptionPackage)
    {
        return [
            "id"=> $userSubscriptionPackage->id,
            "package"=> $userSubscriptionPackage->package,
            "price"=> $userSubscriptionPackage->price,
            "duration_in_months" => $userSubscriptionPackage->duration_in_months,
        ];
    }
}
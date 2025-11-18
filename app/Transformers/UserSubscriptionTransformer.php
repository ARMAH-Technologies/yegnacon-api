<?php
namespace App\Transformers;

use App\Entities\ActiveProject;
use App\Entities\UserSubscription;
use League\Fractal\TransformerAbstract;

class UserSubscriptionTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

    protected $defaultIncludes = [
        'package'
    ];
    
    public function transform(UserSubscription $userSubscription)
    {
        return [
            "id" => $userSubscription->id,
            "expiration_date" => $userSubscription->expiration_date,
            "started_date" => $userSubscription->started_date,
            "package" => $userSubscription->package->package
        ];
    }

    public function includePackage(UserSubscription $userSubscription){
        $package = $userSubscription->package;
        return $this->item($package, new UserSubscriptionPackageTransformer);
    }
}
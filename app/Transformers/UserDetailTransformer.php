<?php

namespace App\Transformers;

use App\Entities\Users\User;
use League\Fractal\TransformerAbstract;

class UserDetailTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;
    protected $defaultIncludes = ['address', 'profile', 'file','subscriptions'];

    protected $profileInclude;

    public function __construct($profileInclude = true)
    {
        $this->profileInclude = $profileInclude;
    }

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'profileType' => $user->profile_type,
            'status' => $user->status,
            'salesPerson'=> $user->subscriptions->count() > 0 ? $this->getCurrentSubscription($user->id)->salesPerson->full_name : "",
            'subscriptionsCount'=>$user->subscriptions->count()
        ];
    }

    public function includeAddress(User $user)
    {
        if ($user->address) {
            return $this->item($user->address, new AddressTransformer());
        }
    }

    public function includeProfile(User $user)
    {
        if ($user->contractor) {
            return $this->item($user->contractor, new ContractorTransformer($this->profileInclude));
        }
        else if ($user->consultant) {
            return $this->item($user->consultant, new ConsultantTransformer($this->profileInclude));
        }
        else if ($user->contractorAndConsultant) {
            return $this->item($user->contractorAndConsultant, new ContractorAndConsultantTransformer($this->profileInclude));
        }
        else if ($user->supplier) {
            return $this->item($user->supplier, new SupplierTransformer($this->profileInclude));
        }
        else  if ($user->professional) {
            return $this->item($user->professional, new ProfessionalTransformer($this->profileInclude));
        }
        else if ($user->projectOwner) {
            return $this->item($user->projectOwner, new ProjectOwnerTransformer($this->profileInclude));
        }
    }

    public function includeFile(User $user)
    {
        if ($user->file) {
            return $this->item($user->file, new FileTransformer());
        }
    }

    public function includeSubscriptions(User $user)
    {
        if($user->subscriptions->count() > 0){
            return $this->item($this->getCurrentSubscription($user->id), new UserSubscriptionTransformer());
        }


    }

}
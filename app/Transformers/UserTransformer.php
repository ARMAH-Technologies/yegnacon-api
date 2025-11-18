<?php

namespace App\Transformers;

use App\Entities\Users\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;
    protected $defaultIncludes = ['address', 'contractor','consultant','contractorAndConsultant',
        'supplier', 'professional', 'projectOwner', 'file','subscriptions'];

    protected $profileInclude;

    public function __construct($profileInclude = true)
    {
        $this->profileInclude = false;
    }

    public function transform(User $user)
    {
        return [
            'id' =>$user->id,
            'name' => $user->name,
            'email' => $user->email,
            'profileType' => $user->profile_type,
            'status' => $user->status,
            'salesPerson'=> $user->subscriptions->count() > 0 ? $this->getCurrentSubscription($user->id)->salesPerson->full_name : ""
        ];
    }

    public function includeAddress(User $user)
    {
        if ($user->address) {
            return $this->item($user->address, new AddressTransformer());
        }
    }

    public function includeContractor(User $user)
    {
        if ($user->contractor) {
            return $this->item($user->contractor, new ContractorTransformer($this->profileInclude));
        }
    }

    public function includeConsultant(User $user)
    {
        if ($user->consultant) {
            return $this->item($user->consultant, new ConsultantTransformer($this->profileInclude));
        }
    }

    public function includeContractorAndConsultant(User $user)
    {
        if ($user->contractorAndConsultant) {
            return $this->item($user->contractorAndConsultant, new ContractorAndConsultantTransformer($this->profileInclude));
        }
    }

    public function includeSupplier(User $user)
    {
        if ($user->supplier) {
            return $this->item($user->supplier, new SupplierTransformer($this->profileInclude));
        }
    }

    public function includeProfessional(User $user)
    {
        if ($user->professional) {
            return $this->item($user->professional, new ProfessionalTransformer($this->profileInclude));
        }
    }

    public function includeProjectOwner(User $user)
    {
       if ($user->projectOwner) {
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
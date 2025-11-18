<?php
namespace App\Transformers;

use App\Entities\ProformaRequest;
use App\Entities\ProformaRequestItem;
use App\Entities\ProformaResponse;
use App\Entities\Users\User;
use App\Repositories\RepositoryHelperTrait;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ProformaRequestDetailTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;
    use RepositoryHelperTrait;

    protected $defaultIncludes = ['proformaRequestItems', 'proformaRequestProjectCost', 'user', 'proformaResponses', 'file'];

    public function transform(ProformaRequest $proformaRequest)
    {
        return [
            'id' => $proformaRequest->id,
            'date' => Carbon::parse($proformaRequest->created_at)->toDateString(),
            'noItems' => $this->countProformaRequestItems($proformaRequest),
            'noReplies' => $this->countProformaRequestResponses($proformaRequest),
            'proforma_request_id' =>$proformaRequest->proforma_request_id+1000,
            'status' => $proformaRequest->status
        ];
    }

    public function includeProformaRequestItems(ProformaRequest $proformaRequest)
    {
        if ($proformaRequest->type === 'Product') {
            $proformaRequestItems = [];

            $user = app('Dingo\Api\Auth\Auth')->user();

            $profileType = $this->getUserProfileType($user->id);

            if ($profileType === 'Supplier') {

                $categoryIds = $this->getUserCategoryIds($user->id, 'Proforma');

                $proformaRequestItems = ProformaRequestItem::where('proforma_request_id', $proformaRequest->id)
                    ->whereIn('category_id', $categoryIds)->get();

            } else if ($profileType === 'Contractor' || $profileType === 'ContractorAndConsultant'
                || $profileType === 'Consultant'
            ) {
                $proformaRequestItems = $proformaRequest->proformaRequestItems;
            }

            return $this->collection($proformaRequestItems, new ProformaRequestItemTransformer());
        }
    }

    public function includeProformaRequestProjectCost(ProformaRequest $proformaRequest)
    {
        if ($proformaRequest->type === 'ProjectCost') {

            return $this->item($proformaRequest->proformaRequestProjectCost, new ProformaRequestProjectCostTransformer());
        }
    }

    public function includeUser(ProformaRequest $proformaRequest)
    {
        $user = User::find($this->getProformaRequesterUser($proformaRequest)->id);

        return $this->item($user, new UserDetailTransformer(false));
    }

    public function includeProformaResponses(ProformaRequest $proformaRequest)
    {

        if ($proformaRequest->proformaResponses->count() > 0) {
            $user = app('Dingo\Api\Auth\Auth')->user();

            $profileType = $this->getUserProfileType($user->id);

            $profile = $this->getUserProfile($user->id);

            if ($proformaRequest->type === 'Product') {

                if ($profileType === 'Supplier') {
                    $proformaResponse = $proformaRequest->proformaResponses
                        ->where('responder_id', $profile->id)
                        ->first();

                    if($proformaResponse) {
                        return $this->item($proformaResponse, new ProformaResponseTransformer());
                    }

                } else if ($profileType === 'Contractor' || $profileType === 'ContractorAndConsultant'
                    || $profileType === 'Consultant'
                ) {
                    return $this->collection($proformaRequest->proformaResponses, new ProformaResponseTransformer());
                }
            } else if ($proformaRequest->type === 'ProjectCost') {
                if ($profileType === 'ProjectOwner') {
                    return $this->collection($proformaRequest->proformaResponses, new ProformaResponseTransformer());
                } else if ($profileType === 'Contractor' || $profileType === 'ContractorAndConsultant'
                    || $profileType === 'Consultant'
                ) {
                    $proformaResponse = $proformaRequest->proformaResponses;
//                        ->where('responder_id', $profile->id)
//                        ->first();

                    return $this->collection($proformaResponse, new ProformaResponseTransformer());
                }
            }

        }
    }

    public function includeFile(ProformaRequest $proformaRequest)
    {
        if ($proformaRequest->file) {
            return $this->item($proformaRequest->file, new FileTransformer());
        }
    }
}
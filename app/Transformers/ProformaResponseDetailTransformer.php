<?php
namespace App\Transformers;

use App\Entities\ProformaRequest;
use App\Entities\ProformaResponse;
use App\Entities\Users\User;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ProformaResponseDetailTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

    protected $defaultIncludes = ['proformaResponseProjectCost', 'file', 'proformaResponseItems',
        'supplier','contractor','consultant','contractorAndConsultant', 'proformaRequest'];

    public function transform(ProformaResponse $proformaResponse)
    {
        return [
            'id' => $proformaResponse->id,
            'company' => $this->getProformaResponderUser($proformaResponse)->name,
            'company_id' => $this->getProformaResponderUser($proformaResponse)->id,
            'logo' => $this->getItemLogo($this->getProfile($proformaResponse->responder_type, $proformaResponse->responder_id), 'User'),
            'date' => Carbon::parse($proformaResponse->created_at)->toDateString(),
            'noReplyItems' => $this->countProformaResponseItems($proformaResponse),
            'validity_date' => $proformaResponse->validity_date

        ];
    }

    public function includeProformaResponseProjectCost(ProformaResponse $proformaResponse)
    {
        if ($proformaResponse->proformaResponseProjectCost){
            return $this->collection($proformaResponse->proformaResponseProjectCost, new ProformaResponseProjectCostTransformer);
        }
    }

    public function includeFile(ProformaResponse $proformaResponse)
    {
        if ($proformaResponse->file){
            return $this->item($proformaResponse->file, new FileTransformer());
        }
    }

    public function includeProformaResponseItems(ProformaResponse $proformaResponse)
    {
        if ($proformaResponse->proformaResponseItems->count() > 0){
            return $this->collection($proformaResponse->proformaResponseItems, new ProformaResponseItemTransformer());
        }
    }

    public function includeSupplier(ProformaResponse $proformaResponse)
    {
        if ($proformaResponse->supplier){
            return $this->item($proformaResponse->supplier->user, new UserTransformer(false));
        }
    }

    public function includeContractor(ProformaResponse $proformaResponse)
    {
        if ($proformaResponse->contractor){
            return $this->item($proformaResponse->contractor->user, new UserTransformer(false));
        }
    }

    public function includeConsultant(ProformaResponse $proformaResponse)
    {
        if ($proformaResponse->consultant){
            return $this->item($proformaResponse->consultant->user, new UserTransformer(false));
        }
    }

    public function includeContractorAndConsultant(ProformaResponse $proformaResponse)
    {
        if ($proformaResponse->contractorAndConsultant){
            return $this->item($proformaResponse->contractorAndConsultant->user, new UserTransformer(false));
        }
    }

    public function includeProformaRequest(ProformaResponse $proformaResponse)
    {
        if ($proformaResponse->proformaRequest){
            return $this->item($proformaResponse->proformaRequest, new ProformaRequestDetailTransformer());
        }
    }
}
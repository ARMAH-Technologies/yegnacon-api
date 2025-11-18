<?php
namespace App\Transformers;

use App\Entities\ProformaRequest;
use App\Entities\ProformaResponse;
use App\Entities\Users\User;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ProformaResponseTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

    protected $defaultIncludes = ['proformaResponseProjectCost', 'file'];

    public function transform(ProformaResponse $proformaResponse)
    {
        return [
            'id' => $proformaResponse->id,
            'proforma_invoice_id' => 1000 + $proformaResponse->proforma_invoice_id,
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
}
<?php
namespace App\Transformers;

use App\Entities\ProformaRequest;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ProformaRequestTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

    protected $defaultIncludes = ['proformaRequestProjectCost', 'file'];

    public function transform(ProformaRequest $proformaRequest)
    {
        return [
            'id' => $proformaRequest->id,
            'proforma_request_id' => 1000 + $proformaRequest->proforma_request_id,
            'company' => $this->getProformaRequesterUser($proformaRequest)->name,
            'company_id' => $this->getProformaRequesterUser($proformaRequest)->id,
            'logo' => $this->getItemLogo($this->getProfile($proformaRequest->requester_type, $proformaRequest->requester_id),'User'),
            'date' => Carbon::parse($proformaRequest->created_at)->toDateString(),
            'noItems' => $this->countProformaRequestItems($proformaRequest),
            'noReplies' => $this->countProformaRequestResponses($proformaRequest),
            'type' => $proformaRequest->type,
            'status' => $proformaRequest->status
        ];
    }

    public function includeProformaRequestProjectCost(ProformaRequest $proformaRequest)
    {
        if ($proformaRequest->type === 'ProjectCost') {
            if ($proformaRequest->proformaRequestProjectCost)
                return $this->item($proformaRequest->proformaRequestProjectCost, new ProformaRequestProjectCostTransformer());
        }
    }

    public function includeFile(ProformaRequest $proformaRequest)
    {
        if ($proformaRequest->file){
            return $this->item($proformaRequest->file, new FileTransformer());
        }
    }
}

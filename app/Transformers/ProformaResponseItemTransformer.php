<?php
namespace App\Transformers;

use App\Entities\ProformaResponseItem;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ProformaResponseItemTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

    public function transform(ProformaResponseItem $proformaResponseItem)
    {
        return [
            'id' => $proformaResponseItem->id,
            'item_name'=>$proformaResponseItem->proformaRequestItem->item_name,
            'proforma_response_id' => $proformaResponseItem->proforma_response_id,
            'company' => $this->getProformaResponderUser($proformaResponseItem->proformaResponse)->name,
            'company_id' => $this->getProformaResponderUser($proformaResponseItem->proformaResponse)->id,
            'logo' => $this->getItemLogo($this->getProfile($proformaResponseItem->proformaResponse->responder_type,
                $proformaResponseItem->proformaResponse->responder_id), 'User'),
            'quantity' => $proformaResponseItem->quantity,
            'price' => $proformaResponseItem->price,
            'unit' => $proformaResponseItem->unit,
            'delivery_type' => $proformaResponseItem->delivery_type,
            'delivery_date' => $proformaResponseItem->delivery_date,
            'description' => $proformaResponseItem->description,
            'date' => Carbon::parse($proformaResponseItem->created_at)->toDateString(),
        ];
    }
}
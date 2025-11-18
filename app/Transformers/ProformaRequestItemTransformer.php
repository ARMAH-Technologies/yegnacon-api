<?php
namespace App\Transformers;

use App\Entities\ProformaRequestItem;
use App\Entities\ProformaResponseItem;
use App\Repositories\RepositoryHelperTrait;
use League\Fractal\TransformerAbstract;

class ProformaRequestItemTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;
    use RepositoryHelperTrait;

    protected $defaultIncludes = ['proformaResponseItems'];

    public function transform(ProformaRequestItem $proformaRequestItem)
    {
        return [
            'id' => $proformaRequestItem->id,
            'item_name' => $proformaRequestItem->item_name,
            'quantity' => $proformaRequestItem->quantity,
            'unit' => $proformaRequestItem->unit,
            'description' => $proformaRequestItem->description
        ];
    }

    public function includeProformaResponseItems(ProformaRequestItem $proformaRequestItem)
    {
        $proformaResponseItems = [];

        $user = app('Dingo\Api\Auth\Auth')->user();

        $profileType = $this->getUserProfileType($user->id);

        $profileId = $this->getUserProfile($user->id)->id;

        if ($profileType === 'Supplier') {
            $proformaResponseItems = ProformaResponseItem::whereHas('proformaResponse', (function ($query) use ($profileId) {
                $query->where('responder_id', $profileId);
            }))
                ->where('proforma_request_item_id', $proformaRequestItem->id)
                ->orderBy('price')
                ->get();
        } else if ($profileType === 'Contractor' || $profileType === 'ContractorAndConsultant'
            || $profileType === 'Consultant') {
            $proformaResponseItems = $proformaRequestItem->proformaResponseItems()->orderBy('price')->get();
        }

        return $this->collection($proformaResponseItems, new ProformaResponseItemTransformer());
    }
}
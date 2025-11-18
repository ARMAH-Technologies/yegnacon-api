<?php
namespace App\Transformers;

use App\Entities\ProformaRequestConsultantCost;
use League\Fractal\TransformerAbstract;

class ProformaRequestConsultantCostTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

    public function transform(ProformaRequestConsultantCost $proformaRequestConsultantCost)
    {
        return [
            'id' => $proformaRequestConsultantCost->id,
            'title' => $proformaRequestConsultantCost->title,
            'description' => $proformaRequestConsultantCost->description
        ];
    }
}
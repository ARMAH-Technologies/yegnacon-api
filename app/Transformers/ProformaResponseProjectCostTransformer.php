<?php
namespace App\Transformers;

use App\Entities\ProformaRequestItem;
use App\Entities\ProformaRequestProjectCost;
use App\Entities\ProformaResponseProjectCost;
use League\Fractal\TransformerAbstract;

class ProformaResponseProjectCostTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

    public function transform(ProformaResponseProjectCost $proformaResponseProjectCost)
    {
        return [
            'id' => $proformaResponseProjectCost->id,
            'title' => $proformaResponseProjectCost->title,
            'description' => $proformaResponseProjectCost->description
        ];
    }
}
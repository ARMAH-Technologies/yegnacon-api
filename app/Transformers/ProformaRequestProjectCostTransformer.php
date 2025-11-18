<?php
namespace App\Transformers;

use App\Entities\ProformaRequestItem;
use App\Entities\ProformaRequestProjectCost;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ProformaRequestProjectCostTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

    public function transform(ProformaRequestProjectCost $proformaRequestProjectCost)
    {
        return [
            'id' => $proformaRequestProjectCost->id,
            'title' => $proformaRequestProjectCost->title,
            'description' => $proformaRequestProjectCost->description,
            'type' => $proformaRequestProjectCost->type,
            'level' => $proformaRequestProjectCost->level
        ];
    }
}
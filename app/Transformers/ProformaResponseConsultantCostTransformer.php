<?php
namespace App\Transformers;

use App\Entities\ProformaRequestItem;
use App\Entities\ProformaRequestProjectCost;
use App\Entities\ProformaResponseConsultantCost;
use App\Entities\ProformaResponseProjectCost;
use League\Fractal\TransformerAbstract;

class ProformaResponseConsultantCostTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

    public function transform(ProformaResponseConsultantCost $proformaResponseConsultantCost)
    {
        return [
            'id' => $proformaResponseConsultantCost->id,
            'title' => $proformaResponseConsultantCost->title,
            'description' => $proformaResponseConsultantCost->description
        ];
    }
}
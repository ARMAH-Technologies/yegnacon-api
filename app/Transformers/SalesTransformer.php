<?php

namespace App\Transformers;

use App\Entities\Sales;
use League\Fractal\TransformerAbstract;

class SalesTransformer extends TransformerAbstract
{
    

    public function transform(Sales $salesPerson)
    {
        return [
            'id' => $salesPerson->id,
            'full_name' => $salesPerson->full_name
        ];
    }


}
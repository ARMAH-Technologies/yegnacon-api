<?php

namespace App\Transformers;

use App\Entities\ContractorAndConsultant;
use League\Fractal\TransformerAbstract;

class ContractorAndConsultantTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['projects'];

    protected $includeDetail;

    public function __construct($includeDetail = true)
    {
        $this->includeDetail = $includeDetail;
    }

    public function transform(ContractorAndConsultant $contractorAndConsultant)
    {
        return [
            'id' => $contractorAndConsultant->id,
            'service_type' => $contractorAndConsultant->service_type,
            'type' => $contractorAndConsultant->type,
            'level' => $contractorAndConsultant->level,
            'established_year' => $contractorAndConsultant->established_year,
            'description' => $contractorAndConsultant->description
        ];
    }

    public function includeProjects(ContractorAndConsultant $contractorAndConsultant)
    {
        if($this->includeDetail) {
            return $this->collection($contractorAndConsultant->projects, new ProjectTransformer());
        }
    }
}
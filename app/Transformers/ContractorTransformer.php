<?php

namespace App\Transformers;

use App\Entities\Contractor;
use App\Entities\Users\User;
use League\Fractal\TransformerAbstract;

class ContractorTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['projects'];

    protected $includeDetail;

    public function __construct($includeDetail = true)
    {
        $this->includeDetail = $includeDetail;
    }

    public function transform(Contractor $contractor)
    {
        return [
            'id' => $contractor->id,
            'service_type' => $contractor->service_type,
            'type' => $contractor->type,
            'level' => $contractor->level,
            'established_year' => $contractor->established_year,
            'description' => $contractor->description
        ];
    }

    public function includeProjects(Contractor $contractor)
    {
        if($this->includeDetail) {
            return $this->collection($contractor->projects, new ProjectTransformer());
        }
    }
}
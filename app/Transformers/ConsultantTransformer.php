<?php

namespace App\Transformers;

use App\Entities\Consultant;
use League\Fractal\TransformerAbstract;

class ConsultantTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['projects'];

    protected $includeDetail;

    public function __construct($includeDetail = true)
    {
        $this->includeDetail = $includeDetail;
    }

    public function transform(Consultant $consultant)
    {
        return [
            'id' => $consultant->id,
            'service_type' => $consultant->service_type,
            'type' => $consultant->type,
            'level' => $consultant->level,
            'established_year' => $consultant->established_year,
            'description' => $consultant->description
        ];
    }

    public function includeProjects(Consultant $consultant)
    {
        if($this->includeDetail) {
            return $this->collection($consultant->projects, new ProjectTransformer());
        }
    }
}
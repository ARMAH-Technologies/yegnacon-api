<?php

namespace App\Transformers;

use App\Entities\Contractor;
use App\Entities\ProjectOwner;
use App\Entities\Users\User;
use League\Fractal\TransformerAbstract;

class ProjectOwnerTransformer extends TransformerAbstract
{
    protected $includeDetail;

    public function __construct($includeDetail = true)
    {
        $this->includeDetail = $includeDetail;
    }

    public function transform(ProjectOwner $projectOwner)
    {
        return [
            'id' => $projectOwner->id,
            'type' => $projectOwner->type
        ];
    }
}
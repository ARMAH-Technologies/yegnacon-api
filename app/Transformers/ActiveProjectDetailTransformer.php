<?php

namespace App\Transformers;

use App\Entities\ActiveProject;
use League\Fractal\TransformerAbstract;

class ActiveProjectDetailTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['user'];

    public function transform(ActiveProject $activeProject)
    {
        return [
            'id' => $activeProject->id,
            'name' => $activeProject->name,
            'type' => $activeProject->type,
            'category' => $activeProject->category,
            'project_option' => $activeProject->project_option,
            'location' => $activeProject->location,
            'expected_time' => $activeProject->expected_time,
            'description' => $activeProject->description,
            'status' => $activeProject->status,
        ];
    }

    public function includeUser(ActiveProject $activeProject)
    {
        if($activeProject->projectOwner) {
            return $this->item($activeProject->projectOwner->user, new UserDetailTransformer());
        }
    }
}
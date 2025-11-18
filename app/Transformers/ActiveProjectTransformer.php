<?php
namespace App\Transformers;

use App\Entities\ActiveProject;
use League\Fractal\TransformerAbstract;

class ActiveProjectTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

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
            'company' => $activeProject->projectOwner->user->name,
            'logo' => $this->getItemLogo($activeProject->projectOwner, 'User')
        ];
    }
}
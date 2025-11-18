<?php

namespace App\Transformers;

use App\Entities\Professional;
use App\Entities\Project;
use App\Entities\Skill;
use League\Fractal\TransformerAbstract;

class SkillTransformer extends TransformerAbstract
{
    public function transform(Skill $skill)
    {
        return [
            'id' => $skill->id,
            'skill' => $skill->skill
        ];
    }
}
<?php

namespace App\Transformers;

use App\Entities\Education;
use League\Fractal\TransformerAbstract;

class EducationTransformer extends TransformerAbstract
{
    public function transform(Education $education)
    {
        return [
            'id' => $education->id,
            'study_field' => $education->study_field,
            'grad_level' => $education->grad_level,
            'school_name' => $education->school_name,
            'started_date' => $education->started_date,
            'ended_date' => $education->ended_date
        ];
    }
}
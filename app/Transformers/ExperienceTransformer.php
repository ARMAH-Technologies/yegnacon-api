<?php

namespace App\Transformers;

use App\Entities\Experience;
use League\Fractal\TransformerAbstract;

class ExperienceTransformer extends TransformerAbstract
{
    public function transform(Experience $experience)
    {
        return [
            'id' => $experience->id,
            'company' => $experience->company,
            'position' => $experience->position,
            'description' => $experience->description,
            'started_date' => $experience->started_date,
            'ended_date' => $experience->ended_date
        ];
    }
}
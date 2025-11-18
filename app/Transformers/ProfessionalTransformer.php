<?php

namespace App\Transformers;

use App\Entities\Professional;
use League\Fractal\TransformerAbstract;

class ProfessionalTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['experiences', 'educations', 'skills'];

    protected $includeDetail;

    public function __construct($includeDetail = true)
    {
        $this->includeDetail = $includeDetail;
    }

    public function transform(Professional $professional)
    {
        return [
            'id' => $professional->id,
            'professional_title' => $professional->professional_title,
            'gender' => $professional->gender,
            'nationality' => $professional->nationality,
            'biography' => $professional->biography
        ];
    }

    public function includeExperiences(Professional $professional)
    {
        if($this->includeDetail) {
            return $this->collection($professional->experiences, new ExperienceTransformer());
        }
    }

    public function includeEducations(Professional $professional)
    {
        if($this->includeDetail) {
            return $this->collection($professional->educations, new EducationTransformer());
        }
    }

    public function includeSkills(Professional $professional)
    {
        if($this->includeDetail) {
            return $this->collection($professional->skills, new SkillTransformer());
        }
    }
}
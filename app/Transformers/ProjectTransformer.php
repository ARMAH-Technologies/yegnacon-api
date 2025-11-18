<?php

namespace App\Transformers;

use App\Entities\Professional;
use App\Entities\Project;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

    protected $defaultIncludes = ['file', 'contractor', 'consultant', 'contractorAndConsultant'];

    public function transform(Project $project)
    {
        return [
            'id' => $project->id,
            'name' => $project->name,
            'category' => $project->category,
            'client' => $project->client,
            'description' => $project->description,
            'elapsed_time' => $project->elapsed_time,
            'cost' => $project->cost,
            'location' => $project->location,
            'created_at' => Carbon::parse($project->created_at)->toDateString(),
            'profile_type' => $project->profile_type,
            //'company' => $this->getProfile($project->profile_type, $project->profile_id)->user->name,
            //'company_id' => $this->getProfile($project->profile_type, $project->profile_id)->user->id,
            //'logo' => $this->getItemLogo($this->getProfile($project->profile_type, $project->profile_id),'User'),
        ];
    }

    public function includeFile(Project $project)
    {
        if ($project->file) {
            return $this->item($project->file, new FileTransformer());
        }
    }

    public function includeContractor(Project $project)
    {
        if ($project->contractor) {
            return $this->item($project->contractor, new ContractorTransformer(false));
        }
    }

    public function includeConsultant(Project $project)
    {
        if ($project->consultant) {
            return $this->item($project->consultant, new ConsultantTransformer(false));
        }
    }

    public function includeContractorAndConsultant(Project $project)
    {
        if ($project->contractorAndConsultant) {
            return $this->item($project->contractorAndConsultant, new ContractorAndConsultantTransformer(false));
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 2/25/2016
 * Time: 8:35 PM
 */

namespace App\Repositories;

use App\Entities\Project;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class ProjectRepository
{
    use RepositoryHelperTrait;
    use UserTrait;

    public function getAllProject(Request $request, $n)
    {
        return Project::searchByName($request)
            ->latest()->paginate($n);

    }

    public function getUserProjects($user_id, $n)
    {
        $profile_id = $this->getUserProfile($user_id)->id;

        return Project::where('profile_id', $profile_id)
            ->latest()
            ->paginate($n);
    }

    public function getProjectDetail($ProjectId)
    {
        return Project::find($ProjectId);
    }

    public function store($input, $userId)
    {
        $profileType = $this->getUserProfileType($userId);

        $profile = $this->getUserProfile($userId);

        $project = $this->saveProject($input->project, $profile->id, $profileType);

        return $project;
    }

    public function update($input)
    {
        $Project = $this->saveProject($input->project);

        return $Project;
    }

    public function delete($ProjectId)
    {
        $Project = Project::find($ProjectId);
        $Project->delete();

        return $Project;
    }

}
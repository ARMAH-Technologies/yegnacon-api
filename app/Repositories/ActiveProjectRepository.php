<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 2/25/2016
 * Time: 8:35 PM
 */

namespace App\Repositories;

use App\Entities\ActiveProject;
use Webpatser\Uuid\Uuid;

class ActiveProjectRepository
{
    use RepositoryHelperTrait;
    use StatusTrait;

    public function getAllActiveProjects($n)
    {
        return ActiveProject::latest()->paginate($n);
    }

    public function getUserActiveProjects($user_id, $n)
    {
        $profileId = $this->getUserProfile($user_id)->id;

        return ActiveProject::where('project_owner_id', $profileId)->latest()->paginate($n);
    }

    public function getActiveProjectDetail($tenderId)
    {
        return ActiveProject::find($tenderId);
    }

    public function store($input, $user_id)
    {
        $projectOwnerId = $this->getUserProfile($user_id)->id;

        $activeProject = $this->saveActiveProject($input->activeProject, $projectOwnerId);

        return $activeProject;
    }

    public function update($input)
    {
        $activeProject = $this->saveActiveProject($input->activeProject);

        return $activeProject;
    }

    public function delete($tenderId)
    {
        $activeProject = ActiveProject::find($tenderId);
        $activeProject->delete();

        return $activeProject;
    }

    private function saveActiveProject($input, $projectOwnerId = null)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $activeProject = ActiveProject::find($id);
            $activeProject->name = $input['name'];
            $activeProject->type = isset($input['type']) ? $input['type'] : $activeProject->type;
            $activeProject->category = isset($input['category']) ? $input['category'] : $activeProject->category;
            $activeProject->project_option = isset($input['project_option']) ? $input['project_option'] : $activeProject->project_option;
            $activeProject->location = isset($input['location']) ? $input['location'] : $activeProject->location;
            $activeProject->expected_time = isset($input['expected_time']) ? $input['expected_time'] : $activeProject->expected_time;
            $activeProject->description = isset($input['description']) ? $input['description'] : $activeProject->description;
            $activeProject->save();
        } else {
            $activeProject = new ActiveProject();
            $activeProject->id = $id = Uuid::generate(4);
            $activeProject->project_owner_id = $projectOwnerId;
            $activeProject->name = $input['name'];
            $activeProject->type = isset($input['type']) ? $input['type'] : null;
            $activeProject->category = isset($input['category']) ? $input['category'] : null;
            $activeProject->project_option = isset($input['project_option']) ? $input['project_option'] : null;
            $activeProject->location = isset($input['location']) ? $input['location'] : null;
            $activeProject->expected_time = isset($input['expected_time']) ? $input['expected_time'] : null;
            $activeProject->description = isset($input['description']) ? $input['description'] : null;
            $activeProject->status = $this->activeProjectStatus;
            $activeProject->save();
        }

        return ActiveProject::find($id);
    }

}
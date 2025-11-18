<?php

namespace App\Http\Controllers;

use App\Repositories\ProjectRepository;
use App\Transformers\ProjectTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use Helpers;

    protected $projectRepository;
    protected $per_page = 10;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function index(Request $request)
    {
        $project = $this->projectRepository->getAllProject($request, $this->per_page);

        $response = $this->response->paginator($project, new ProjectTransformer());

        return $response;
    }

    public function store(Request $request, $userId)
    {
        $project = $this->projectRepository->store($request , $userId);

        $response = $this->response->item($project, new ProjectTransformer());

        return $response;
    }

    public function show($projectId)
    {
        $project = $this->projectRepository->getProjectDetail($projectId);

        $response = $this->response->item($project, new ProjectTransformer());

        return $response;
    }

    public function update(Request $request)
    {
        $project = $this->projectRepository->update($request);

        $response = $this->response->item($project, new ProjectTransformer());

        return $response;
    }

    public function destroy($projectId)
    {
        $project = $this->projectRepository->delete($projectId);

        $response = $this->response->item($project, new ProjectTransformer());

        return $response;
    }

    public function getUserProjects($userId)
    {
        $projects = $this->projectRepository->getUserProjects($userId,$this->per_page);

        $response = $this->response->paginator($projects, new ProjectTransformer());

        return $response;
    }
}

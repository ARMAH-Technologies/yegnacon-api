<?php

namespace App\Http\Controllers;

use App\Repositories\ActiveProjectRepository;
use App\Transformers\ActiveProjectDetailTransformer;
use App\Transformers\ActiveProjectTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ActiveProjectController extends Controller
{
    use Helpers;

    protected $activeProjectRepository;
    protected $per_page = 10;

    public function __construct(ActiveProjectRepository $activeProjectRepository)
    {
        $this->activeProjectRepository = $activeProjectRepository;
    }

    public function index()
    {
        $activeProjects = $this->activeProjectRepository->getAllActiveProjects($this->per_page);

        $response = $this->response->paginator($activeProjects, new ActiveProjectTransformer());

        return $response;
    }

    public function store(Request $request, $user_id)
    {
        $activeProject = $this->activeProjectRepository->store($request, $user_id);

        $response = $this->response->item($activeProject, new ActiveProjectTransformer());

        return $response;
    }

    public function show($vacancyId)
    {
        $activeProject = $this->activeProjectRepository->getActiveProjectDetail($vacancyId);

        $response = $this->response->item($activeProject, new ActiveProjectDetailTransformer());

        return $response;
    }

    public function update(Request $request)
    {
        $activeProject = $this->activeProjectRepository->update($request);

        $response = $this->response->item($activeProject, new ActiveProjectTransformer());

        return $response;
    }

    public function destroy($tenderId)
    {
        $activeProject = $this->activeProjectRepository->delete($tenderId);

        $response = $this->response->item($activeProject, new ActiveProjectTransformer());

        return $response;
    }

    public function getUserActiveProjects($userId)
    {
        $activeProjects = $this->activeProjectRepository->getUserActiveProjects($userId, $this->per_page);

        $response = $this->response->paginator($activeProjects, new ActiveProjectTransformer());

        return $response;
    }
}

<?php

namespace App\Http\Controllers;

use App\Repositories\VacancyRepository;
use App\Transformers\VacancyDetailTransformer;
use App\Transformers\VacancyTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    use Helpers;

    protected $vacancyRepository;
    protected $per_page = 7;

    public function __construct(VacancyRepository $vacancyRepository)
    {
        $this->vacancyRepository = $vacancyRepository;
    }

    public function index(Request $request)
    {
        $vacancies = $this->vacancyRepository->getAllVacancies($request, $this->per_page);

        $response = $this->response->paginator($vacancies, new VacancyTransformer());

        return $response;
    }

    public function store(Request $request)
    {
        $vacancy = $this->vacancyRepository->store($request);

        $response = $this->response->item($vacancy, new VacancyTransformer());

        return $response;
    }

    public function show($vacancyId)
    {
        $vacancy = $this->vacancyRepository->getVacancyDetail($vacancyId);

        $response = $this->response->item($vacancy, new VacancyDetailTransformer());

        return $response;
    }

    public function update(Request $request)
    {
        $vacancy = $this->vacancyRepository->update($request);

        $response = $this->response->item($vacancy, new VacancyTransformer());

        return $response;
    }

    public function destroy($vacancyId)
    {
        $vacancy = $this->vacancyRepository->delete($vacancyId);

        $response = $this->response->item($vacancy, new VacancyTransformer());

        return $response;
    }

    public function getUserVacancies($userId)
    {
        $vacancies = $this->vacancyRepository->getUserVacancies($userId, $this->per_page);

        $response = $this->response->paginator($vacancies, new VacancyTransformer());

        return $response;
    }

    public function getCompanyVacancies($companyId)
    {
        $vacancies = $this->vacancyRepository->getCompanyVacancies($companyId, $this->per_page);

        $response = $this->response->paginator($vacancies, new VacancyTransformer());

        return $response;
    }
    public function getStatistics(){
        $vacanciesCount = $this->vacancyRepository->getVacanciesCount();
        return $vacanciesCount;
    }

}

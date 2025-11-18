<?php

namespace App\Http\Controllers;

use App\Repositories\TenderRepository;
use App\Transformers\TenderDetailTransformer;
use App\Transformers\TenderTransformer;
use Carbon\Carbon;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    use Helpers;

    protected $tenderRepository;
    protected $per_page = 7;

    public function __construct(TenderRepository $tenderRepository)
    {
        $this->tenderRepository = $tenderRepository;
    }

    public function index(Request $request)
    {
        $tenders = $this->tenderRepository->getAllTenders($request, $this->per_page);

        $response = $this->response->paginator($tenders, new TenderTransformer());

        return $response;
    }

    public function store(Request $request)
    {
        $tender = $this->tenderRepository->store($request);

        $response = $this->response->item($tender, new TenderTransformer());

        return $response;
    }

    public function show($tenderId)
    {
        $tender = $this->tenderRepository->getTenderDetail($tenderId);

        $response = $this->response->item($tender, new TenderDetailTransformer());

        return $response;
    }

    public function update(Request $request)
    {
        $tender = $this->tenderRepository->update($request);

        $response = $this->response->item($tender, new TenderTransformer());

        return $response;
    }

    public function destroy($tenderId)
    {
        $vacancy = $this->tenderRepository->delete($tenderId);

        $response = $this->response->item($vacancy, new TenderTransformer());

        return $response;
    }

    public function getUserTenders($userId)
    {
        $tenders = $this->tenderRepository->getUserTenders($userId, $this->per_page);

        $response = $this->response->paginator($tenders, new TenderTransformer());

        return $response;
    }

    public function getCompanyTenders($companyId)
    {
        $tenders = $this->tenderRepository->getCompanyTenders($companyId, $this->per_page);

        $response = $this->response->paginator($tenders, new TenderTransformer());

        return $response;
    }

    public function getStatistics()
    {
        $vacanciesCount = $this->tenderRepository->getTendersCount();

        return $vacanciesCount;
    }

    public function getUserTendersByCategories(Request $request)
    {
        if ($user = app('Dingo\Api\Auth\Auth')->user()) {
            $userId = $user->id;
            $tenders = $this->tenderRepository->getUserTendersByCategories($request, $userId, $this->per_page);
        } else {
            $tenders = $this->tenderRepository->getAllTenders($request, $this->per_page);
        }

        $response = $this->response->paginator($tenders, new TenderTransformer());

        return $response;
    }

    public function sendYesterdayTendersToUsers()
    {
        return $this->tenderRepository->sendYesterdayTendersToUsers();
    }
}

<?php

namespace App\Http\Controllers;


use App\Repositories\ProformaRepository;
use App\Transformers\ProformaRequestDetailTransformer;
use App\Transformers\ProformaRequestItemTransformer;
use App\Transformers\ProformaRequestProjectCostTransformer;
use App\Transformers\ProformaRequestTransformer;
use App\Transformers\ProformaResponseDetailTransformer;
use App\Transformers\ProformaResponseTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ProformaController extends Controller
{
    use Helpers;

    protected $proformaRepository;
    protected $per_page = 10;

    public function __construct(ProformaRepository $proformaRepository)
    {
        $this->proformaRepository = $proformaRepository;
    }

    public function index()
    {
        $proformaRequests = $this->proformaRepository->getAllProformaRequests($this->per_page);

        $response = $this->response->paginator($proformaRequests, new ProformaRequestTransformer());

        return $response;
    }

    public function request(Request $request)
    {

        $userId = app('Dingo\Api\Auth\Auth')->user()->id;

        $proformaRequest = $this->proformaRepository->storeProformaRequest($request,$userId);

        $response = $this->response->item($proformaRequest, new ProformaRequestTransformer());

        return $response;
    }

    public function update(Request $request)
    {

        $userId = app('Dingo\Api\Auth\Auth')->user()->id;

        $proformaRequest = $this->proformaRepository->update($request,$userId);

        $response = $this->response->item($proformaRequest, new ProformaRequestTransformer());

        return $response;
    }

    public function reply(Request $request, $userId, $proformaRequestId)
    {
        $proformaResponse = $this->proformaRepository->storeProformaResponse($request, $userId, $proformaRequestId);

        $response = $this->response->item($proformaResponse, new ProformaResponseTransformer());

        return $response;
    }

    public function show($proformaId)
    {
        $proformaRequest = $this->proformaRepository->getProformaRequestDetail($proformaId);

        $response = $this->response->item($proformaRequest, new ProformaRequestDetailTransformer());

        return $response;
    }

    public function getUserProductProformaRequests($userId)
    {
        $proformaRequests = $this->proformaRepository->getUserProductProformaRequests($userId, $this->per_page);

        $response = $this->response->collection($proformaRequests, new ProformaRequestTransformer());

        return $response;
    }

    public function getUserProjectProformaRequests($userId)
    {
        $proformaRequests = $this->proformaRepository->getProjectRequesterProformaRequests($userId, $this->per_page);

        $response = $this->response->paginator($proformaRequests, new ProformaRequestTransformer());

        return $response;
    }

    public function getProjectFromCompanyProformaRequests($userId)
    {
        $proformaRequests = $this->proformaRepository->getProjectReplierProformaRequests($userId, $this->per_page);
        $response = $this->response->paginator($proformaRequests, new ProformaRequestTransformer());
        return $response;
    }

    public function getProformaResponses($proformaId)
    {
        $proformaResponses = $this->proformaRepository->getProformaResponses($proformaId, $this->per_page);

        $response = $this->response->paginator($proformaResponses, new ProformaResponseTransformer());

        return $response;
    }

    public function getProformaRequestItems($proformaId)
    {
        $proformaRequestItems = $this->proformaRepository->getProformaRequestItems($proformaId, $this->per_page);

        $response = $this->response->paginator($proformaRequestItems, new ProformaRequestItemTransformer());

        return $response;
    }

    public function getProformaResponseDetail($proformaResponseId)
    {
        $proformaResponse = $this->proformaRepository->getProformaResponseDetail($proformaResponseId);

        $response = $this->response->item($proformaResponse, new ProformaResponseDetailTransformer());

        return $response;
    }

    public function getStatistics(){

        $proformaStat = $this->proformaRepository->getProformasCount();

        return $proformaStat;
    }
}

<?php

namespace App\Http\Controllers;

use App\Repositories\UserCategoryRepository;
use App\Repositories\UserRepository;
use App\Transformers\CategoryTransformer;
use App\Transformers\TenderDetailTransformer;
use Illuminate\Http\Request;
use App\Entities\Categories_users;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Transformers\MytenderTransformer;
use App\Transformers\MytenderdetailTransformer;
use Dingo\Api\Routing\Helpers;

class UserCategoryController extends Controller
{
    use Helpers;
    private $userCategoryRepository;

    public function __construct(UserCategoryRepository $UserCategoryRepository)
    {
        $this->userCategoryRepository= $UserCategoryRepository;

    }
    public function store(Request $request, $user_id)
    {
        $userCategories = $this->userCategoryRepository->store($request, $user_id);

        $response = $this->response->collection($userCategories, new CategoryTransformer());

        return $response;
    }

    public function getAllCategories()
    {
        $categories = $this->userCategoryRepository->getAllCategories();

        $response = $this->response->collection($categories, new CategoryTransformer());

        return $response;
    }

    public function getUserCategories($user_id)
    {
        $categories = $this->userCategoryRepository->getUserCategories($user_id);

        $response = $this->response->collection($categories, new CategoryTransformer());

        return $response;
    }
    public function getUserTenders($user_id)
    {
        $tenders = $this->userCategoryRepository->getUserTenders($user_id);

        $response = $this->response->collection($tenders, new TenderDetailTransformer());

        return $response;
    }
}

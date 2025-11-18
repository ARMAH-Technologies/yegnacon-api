<?php
/**
 * Created by PhpStorm.
 * User: yido
 * Date: 8/14/16
 * Time: 12:49 PM
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repositories\UserSubscriptionPackageRepository;
use App\Transformers\UserSubscriptionPackageTransformer;
use Dingo\Api\Routing\Helpers;

use Illuminate\Http\Request;


class UserSubscriptionPackageController extends Controller
{
    use Helpers;
    protected $userSubscriptionPackageRepository;

    public function __construct(UserSubscriptionPackageRepository $userSubscriptionPackageRepository)
    {
        $this->userSubscriptionPackageRepository = $userSubscriptionPackageRepository;
    }

    public function index(Request $request)
    {
        $sales = $this->userSubscriptionPackageRepository->getAllSubscriptionPackageRepositories();

        $response = $this->response->collection($sales, new UserSubscriptionPackageTransformer());


        return $response;
    }

}
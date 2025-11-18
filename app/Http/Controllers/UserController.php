<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repositories\TenderRepository;
use App\Repositories\UserRepository;
use App\Transformers\GroupTransformer;
use App\Transformers\ProfessionalTransformer;
use App\Transformers\ProformaGroupTransformer;
use App\Transformers\UserDetailTransformer;
use App\Transformers\UserDropDownTransformer;
use App\Transformers\UserTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    use Helpers;
    protected $userRepository;
    protected $tenderRepository;


    protected $per_page = 1;

    public function __construct(UserRepository $userRepository, TenderRepository $tenderRepository)
    {
        $this->userRepository = $userRepository;
        $this->tenderRepository = $tenderRepository;
    }

    public function index(Request $request)
    {
        if ($request->has('dropdown')) {
            $users = $this->userRepository->getAllUsers($request, true, $this->per_page);

            $response = $this->response->collection($users, new UserDropDownTransformer());
        } else {
            $users = $this->userRepository->getAllUsers($request, false, $this->per_page);

            $response = $this->response->paginator($users, new UserTransformer());
        }

        return $response;
    }

    public function store(Request $request)
    {
        $user = $this->userRepository->storeUser($request);

        $response = $this->response->item($user, new UserTransformer());

        return $response;
    }

    public function show($user_id)
    {
        $user = $this->userRepository->getUserDetail($user_id);


        $response = $this->response->item($user, new UserDetailTransformer());

        return $response;
    }

    public function update(Request $request)
    {
        $user_id = app('Dingo\Api\Auth\Auth')->user()->id;
        //dd($user_id);
        $user = $this->userRepository->update($request, $user_id);

        $response = $this->response->item($user, new UserTransformer());

        return $response;
    }

    public function updateUser(Request $request)
    {
        $user = $this->userRepository->update($request, $request->user->id);

        $response = $this->response->item($user, new UserTransformer());

        return $response;
    }

    public function  getCurrentUser()
    {
        $user = $this->userRepository->getCurrentUser();

        $response = $this->response->item($user, new UserTransformer());

        return $response;
    }

    public function changeStatus($user_id, $status)
    {
        $user = $this->userRepository->changeStatus($user_id, $status);

        $response = $this->response->item($user, new UserTransformer());

        return $response;
    }

    public function subscribe(Request $request)
    {

        $user_id = $request->user_id;
        $sales_id = $request->sales_id;
        $package_id = $request->package_id;
        $user = $this->userRepository->subscribe($user_id, $sales_id, $package_id);

        $response = $this->response->item($user, new UserTransformer());
        return $response;

    }

    public function addExperience(Request $request, $professional_id)
    {
        $professional = $this->userRepository->addExperience($request, $professional_id);

        $response = $this->response->item($professional, new ProfessionalTransformer());

        return $response;

    }

    public function getStatistics(Request $request)
    {
        $stat = $this->userRepository->getStatistics();
        return $stat;
    }

    public function changePassword($user_id, $oldPassword, $newPassword)
    {
        return $this->userRepository->changePassword($user_id, $oldPassword, $newPassword);
    }

    public function changeUserName($user_id, $userName)
    {
        return $this->userRepository->changeUserName($user_id, $userName);
    }

    public function resetPassword($user_id, $newPassword)
    {
        return $this->userRepository->resetPassword($user_id, $newPassword);
    }

    public function getUserGroups(Request $request, $user_id)
    {

        if ($request->has('dropdown')) {
            $proforma_groups = $this->userRepository->getAllGroups($user_id);
            $response = $this->response->item($proforma_groups, new GroupTransformer());
        } else {
            $proforma_groups = $this->userRepository->getUserGroups($user_id, $this->per_page);
            $response = $this->response->paginator($proforma_groups, new GroupTransformer());

        }
        
        return $response;
    }


}

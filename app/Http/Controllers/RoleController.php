<?php

namespace App\Http\Controllers;

use App\Repositories\RoleRepository;
use App\Transformers\RoleTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Http\Requests;

class RoleController extends Controller
{
    use Helpers;
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $roles =  $this->roleRepository->getAllRoles();

        $response = $this->response->collection($roles, new RoleTransformer());

        return $response;
    }

    public function store(Request $request)
    {
        $role =  $this->roleRepository->storeRole($request);

        $response = $this->response->item($role, new RoleTransformer());

        return $response;
    }

    public function show($id)
    {
        $role =  $this->roleRepository->getRoleDetail($id);

        $response = $this->response->item($role, new RoleTransformer());

        return $response;
    }

    public function assignRoleToUser(Request $request, $user_id)
    {
        $roles =  $this->roleRepository->assignRole($request,$user_id);

        $response = $this->response->collection($roles, new RoleTransformer());

        return $response;
    }

    public function getUserRoles($user_id)
    {
        $roles = $this->roleRepository->getUserRoles($user_id);

        $response = $this->response->collection($roles, new RoleTransformer());

        return $response;
    }
}

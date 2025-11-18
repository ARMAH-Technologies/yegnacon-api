<?php

namespace App\Http\Controllers;

use App\Repositories\PermissionRepository;
use App\Transformers\PermissionTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Http\Requests;

class PermissionController extends Controller
{
    use Helpers;
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAllPermissions()
    {
        $roles = $this->permissionRepository->getAllPermissions();

        $response = $this->response->collection($roles, new PermissionTransformer());

        return $response;
    }

    public function assignPermissionToRole(Request $request, $role_id)
    {
        $this->permissionRepository->attachPermissionToRole($role_id, $request->permission_ids);
    }
}

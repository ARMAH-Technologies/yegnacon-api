<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 3/24/2016
 * Time: 2:23 PM
 */

namespace App\Repositories;

use App\Entities\Building;
use App\Entities\Users\Permission;
use App\Entities\Users\Role;
use App\Entities\Users\User;
use App\Entities\Vendor;
use Webpatser\Uuid\Uuid;

class PermissionRepository
{
    public function getAllPermissions()
    {
        return Permission::orderBy('description', 'asc')->get();
    }

    public function getUserPermissions($user_id)
    {
        return User::find($user_id)->roles;
    }

    public function attachPermissionToRole($role_id, $permission_ids)
    {
        Role::find($role_id)->perms()->detach();

        Role::find($role_id)->perms()->sync($permission_ids);
    }
}
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

class RoleRepository
{
    public function getAllRoles()
    {
        return Role::orderBy('name', 'dsc')->get();
    }

    public function getRoleDetail($role_id)
    {
        return Role::find($role_id);
    }

    public function getUserRoles($user_id)
    {
        $user_roles = User::find($user_id)->roles;

        $permissions = collect();
        foreach ($user_roles as $role) {
            $permissions->push($role->perms);
        }

        return $permissions;
    }

    public function storeRole($input)
    {
        $role = $this->saveRole($input->role);
        $this->attachPermissionToRole($role->id, $input->permission_ids);

        return $role;
    }

    public function assignRole($input, $user_id)
    {
        $this->attachRoleToUser($user_id, $input->role_ids);

        return User::find($user_id)->roles;
    }

    private function saveRole($input)
    {
        $id = null;
        if (isset($input['id'])) {
            $id = $input['id'];
            $role = Role::find($id);
            $role->name = isset($input['name']) ? $input['name'] :  $role->name;
            $role->display_name = $input['display_name'];
            $role->save();
        } else {
            $id = Uuid::generate(4);
            $role = Role::create([
                'id' => $id,
                'name' => isset($input['name']) ? $input['name'] : '',
                'display_name' => $input['display_name']
            ]);
        }

        return $role;
    }

    private function attachRoleToUser($user_id, $role_ids)
    {
        User::find($user_id)->roles()->detach();

        User::find($user_id)->roles()->sync($role_ids);
    }
}
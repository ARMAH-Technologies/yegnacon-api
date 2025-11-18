<?php

use App\Entities\Users\Permission;
use App\Entities\Users\Role;
use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();
        foreach($permissions as $permission){
            Role::where('name', 'system-admin')->first()->perms()->attach($permission->id);
            Role::where('name', 'system-user')->first()->perms()->attach($permission->id);
        }
    }
}

<?php

use App\Entities\Users\Role;
use App\Entities\Users\User;
use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'system-admin')->first();
        User::first()->roles()->sync([$role->id]);
    }
}

<?php

use App\Entities\Education;
use App\Entities\Users\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Webpatser\Uuid\Uuid;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        factory(User::class, 1)->create(['email' => 'admin@yegnacon.com', 'profile_type' => 'Admin']);
        factory(User::class, 1)->create(['email' => 'hayat@yegnacon.com', 'profile_type' => 'Admin']);
        factory(User::class, 1)->create(['email' => 'ahmed@yegnacon.com', 'profile_type' => 'Admin']);
        //factory(User::class, 1)->create(['profile_type' => 'Contractor']);
       // factory(User::class, 1)->create(['profile_type' => 'Supplier']);
       // factory(User::class, 1)->create(['profile_type' => 'ProjectOwner']);
       // factory(User::class, 1)->create(['profile_type' => 'Professional']);

    }
}

<?php

use App\Entities\Users\User;
use App\Repositories\RepositoryHelperTrait;
use App\Repositories\UserTrait;
use Illuminate\Database\Seeder;

class CreateProfileToNotHaveUsersTableSeeder extends Seeder
{
    use RepositoryHelperTrait;
    use UserTrait;

    public function run()
    {
        foreach(User::all() as $user) {
            $profile = $this->getUserProfile($user->id);

            if (!$profile) {
                $this->saveProfile($user->id);
            }
        }


    }
}

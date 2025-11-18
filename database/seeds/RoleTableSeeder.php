<?php

use App\Entities\Users\Role;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id' => Uuid::generate(4),
            'name' => 'system-admin',
            'display_name' => 'System Admin'
        ]);
        Role::create([
            'id' => Uuid::generate(4),
            'name' => 'system-user',
            'display_name' => 'System User'
        ]);
        Role::create([
            'id' => Uuid::generate(4),
            'name' => 'client',
            'display_name' => 'Client'
        ]);
        Role::create([
            'id' => Uuid::generate(4),
            'name' => 'monitor',
            'display_name' => 'Monitor'
        ]);
        Role::create([
            'id' => Uuid::generate(4),
            'name' => 'plan-maker',
            'display_name' => 'Plan Maker'
        ]);
        Role::create([
            'id' => Uuid::generate(4),
            'name' => 'media-manager',
            'display_name' => 'Media Manager'
        ]);
        Role::create([
            'id' => Uuid::generate(4),
            'name' => 'finance',
            'display_name' => 'Finance'
        ]);
        Role::create([
            'id' => Uuid::generate(4),
            'name' => 'ceo',
            'display_name' => 'CEO'
        ]);
    }
}

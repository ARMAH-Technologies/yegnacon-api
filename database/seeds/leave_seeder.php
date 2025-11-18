<?php

use App\Entities\Category;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class leave_seeder extends Seeder
{

    public function run()
    {
        \App\Entities\Leave::create([
            'name' => "Annual Leave",
        ]);
        \App\Entities\Leave::create([
            'name' => "Sick Leave",
        ]);
        \App\Entities\Leave::create([
            'name' => "Maternity Leave",
        ]);
        \App\Entities\Leave::create([
            'name' => "Marriage Leave",
        ]);
        \App\Entities\Leave::create([
            'name' => "Leave Without Pay",
        ]);
        \App\Entities\Leave::create([
            'name' => "Moaning Leave",
        ]);
        \App\Entities\Leave::create([
            'name' => 'Paternity Leave',
        ]);
    }
}

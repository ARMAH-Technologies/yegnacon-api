<?php

use Illuminate\Database\Seeder;
use App\Entities\Users;
use App\Entities\Sales;
use App\Entities\UserSubscriptionPackage;
use App\Entities\UserSubscription;
use Webpatser\Uuid\Uuid;
use App\Entities\Users\User;
class UserSubscriptionSeeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        UserSubscriptionPackage::create([
            'id' => Uuid::generate(4),
            'package' => "Standard",
            'duration_in_months' => 1,
            'price' => 0.00
        ]);
        UserSubscriptionPackage::create([
            'id' => Uuid::generate(4),
            'package' => "Standard",
            'duration_in_months' => 3,
            'price' => 0.00
        ]);
        UserSubscriptionPackage::create([
            'id' => Uuid::generate(4),
            'package' => "Standard",
            'duration_in_months' => 6,
            'price' => 0.00
        ]);
        UserSubscriptionPackage::create([
            'id' => Uuid::generate(4),
            'package' => "Corporate",
            'duration_in_months' => 1,
            'price' => 0.00
        ]);
        UserSubscriptionPackage::create([
            'id' => Uuid::generate(4),
            'package' => "Corporate",
            'duration_in_months' => 3,
            'price' => 0.00
        ]);
        UserSubscriptionPackage::create([
            'id' => Uuid::generate(4),
            'package' => "Corporate",
            'duration_in_months' => 6,
            'price' => 0.00
        ]);
        UserSubscriptionPackage::create([
            'id' => Uuid::generate(4),
            'package' => "Premium",
            'duration_in_months' => 1,
            'price' => 0.00
        ]);
        UserSubscriptionPackage::create([
            'id' => Uuid::generate(4),
            'package' => "Premium",
            'duration_in_months' => 3,
            'price' => 0.00
        ]);
        UserSubscriptionPackage::create([
            'id' => Uuid::generate(4),
            'package' => "Premium",
            'duration_in_months' => 6,
            'price' => 0.00
        ]);

        Sales::create([
           'id' => Uuid::generate(4),
            'full_name'=> "Sales 004"
        ]);
        Sales::create([
            'id' => Uuid::generate(4),
            'full_name'=> "Sales 005"
        ]);
        Sales::create([
            'id' => Uuid::generate(4),
            'full_name'=> "Sales 006"
        ]);
        Sales::create([
            'id' => Uuid::generate(4),
            'full_name'=> "Sales 007"
        ]);
        Sales::create([
            'id' => Uuid::generate(4),
            'full_name'=> "Sales 008"
        ]);
        Sales::create([
            'id' => Uuid::generate(4),
            'full_name'=> "Sales 009"
        ]);
        Sales::create([
            'id' => Uuid::generate(4),
            'full_name'=> "Sales 010"
        ]);
        Sales::create([
            'id' => Uuid::generate(4),
            'full_name'=> "Free Agent"
        ]);


    /*    UserSubscriptionPackage::create([
            'id' => Uuid::generate(4),
            'package' => "Standard",
            'duration_in_months' => 12,
            'price' => 990.00
        ]);
        UserSubscriptionPackage::create([
            'id' => Uuid::generate(4),
            'package' => "Corporate",
            'duration_in_months' => 12,
            'price' => 1990.00
        ]);
        UserSubscriptionPackage::create([
            'id' => Uuid::generate(4),
            'package' => "Premium",
            'duration_in_months' => 12,
            'price' => 2990.00
        ]);

        Sales::create([
            'id' => Uuid::generate(4),
            'full_name'=> "Salesman 1"
        ]);
        Sales::create([
            'id' => Uuid::generate(4),
            'full_name'=> "Salesman 2"
        ]);
        Sales::create([
            'id' => Uuid::generate(4),
            'full_name'=> "Salesman 3"
        ]);*/


/*
        $users = User::all();
        $sales = Sales::all();
        $packages = UserSubscriptionPackage::all();


        foreach($users as $user) {
            $default_start_date = \Carbon\Carbon::now();
            $default_expiry_date = \Carbon\Carbon::create();
            $default_expiry_date->addYear(1);

            $userSubscripiton = new UserSubscription();
            $userSubscripiton->id = Uuid::generate(4);
            $userSubscripiton->user_id = $user->id;
            $userSubscripiton->sales_id = $sales->random()->id;
            $userSubscripiton->subscription_package_id = $packages->random()->id;
            $userSubscripiton->expiration_date = $default_expiry_date;
            $userSubscripiton->started_date = $default_start_date;

            $userSubscripiton->save();
        }*/


    }
}

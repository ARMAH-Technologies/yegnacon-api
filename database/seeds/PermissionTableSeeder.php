<?php

use App\Entities\Users\Permission;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //client permission seeder starts here
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'client-list',
            'display_name' => 'Clients List',
            'description' => "client"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'client-create',
            'display_name' => 'Create Clients',
            'description' => "client"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'client-edit',
            'display_name' => 'Edit Clients',
            'description' => "client"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'client-delete',
            'display_name' => 'Delete Clients',
            'description' => "client"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'client-status',
            'display_name' => 'Clients status',
            'description' => "client"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'client-detail',
            'display_name' => 'Clients Detail',
            'description' => "client"
        ]);

        //client permission seeder ends here



        //Campaign permission seeder starts here
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'campaign-list',
            'display_name' => 'Campaign List',
            'description' => "campaign"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'campaign-create',
            'display_name' => 'Create Campaign',
            'description' => "campaign"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'campaign-edit',
            'display_name' => 'Edit Campaign',
            'description' => "campaign"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'campaign-delete',
            'display_name' => 'Delete Campaign',
            'description' => "campaign"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'campaign-status',
            'display_name' => 'Campaign status',
            'description' => "campaign"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'campaign-detail',
            'display_name' => 'Campaign Detail',
            'description' => "campaign"
        ]);

        //campaign permission seeder ends here


        //plan permission seeder starts here
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'plan-list',
            'display_name' => 'Plans List',
            'description' => "plan"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'plan-create',
            'display_name' => 'Create plan',
            'description' => "plan"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'plan-edit',
            'display_name' => 'Edit Plans',
            'description' => "plan"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'plan-delete',
            'display_name' => 'Delete Plans',
            'description' => "plan"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'plan-status',
            'display_name' => 'Plans status',
            'description' => "plan"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'plan-detail',
            'display_name' => 'Plans Detail',
            'description' => "plan"
        ]);

        //plan permission seeder ends here

        //schedule permission seeder starts here
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'schedule-list',
            'display_name' => 'Schedule List',
            'description' => "schedule"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'schedule-create',
            'display_name' => 'Create Schedules',
            'description' => "plan"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'schedule-edit',
            'display_name' => 'Edit Schedules',
            'description' => "schedule"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'schedule-delete',
            'display_name' => 'Delete schedule',
            'description' => "schedule"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'schedule-status',
            'display_name' => 'Schedule status',
            'description' => "schedule"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'schedule-detail',
            'display_name' => 'Schedule Detail',
            'description' => "schedule"
        ]);

        //Schedule permission seeder ends here


        //price permission seeder starts here
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'price-list',
            'display_name' => 'Price List',
            'description' => "price"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'price-create',
            'display_name' => 'create price',
            'description' => "plan"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'price-edit',
            'display_name' => 'Edit Price',
            'description' => "price"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'price-delete',
            'display_name' => 'Delete Price',
            'description' => "price"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'price-status',
            'display_name' => 'Price status',
            'description' => "price"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'price-detail',
            'display_name' => 'price Detail',
            'description' => "price"
        ]);

        //Schedule permission seeder ends here



        //Vendors permission seeder starts here
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'vendor-finance',
            'display_name' => 'Vendors Financial',
            'description' => "vendor"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'vendor-list',
            'display_name' => 'Vendors List',
            'description' => "vendor"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'vendor-create',
            'display_name' => 'Create Vendors',
            'description' => "vendor"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'vendor-edit',
            'display_name' => 'Edit Vendors',
            'description' => "vendor"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'vendor-delete',
            'display_name' => 'Delete vendors',
            'description' => "vendor"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'vendor-status',
            'display_name' => 'Vendors status',
            'description' => "vendor"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'vendor-detail',
            'display_name' => 'Vendors Detail',
            'description' => "vendor"
        ]);

        //Vendors permission seeder ends here


        //Category permission seeder starts here
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'category-list',
            'display_name' => 'Category List',
            'description' => "category"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'category-create',
            'display_name' => 'Create Categories',
            'description' => "category"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'category-edit',
            'display_name' => 'Edit category',
            'description' => "category"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'category-delete',
            'display_name' => 'Delete category',
            'description' => "category"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'category-status',
            'display_name' => 'Category status',
            'description' => "category"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'category-detail',
            'display_name' => 'Category Detail',
            'description' => "category"
        ]);

        //category permission seeder ends here



        //discount permission seeder starts here
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'discount-list',
            'display_name' => 'Discount List',
            'description' => "discount"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'discount-create',
            'display_name' => 'Create Discount',
            'description' => "discount"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'discount-edit',
            'display_name' => 'Edit Discount ',
            'description' => "discount"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'discount-delete',
            'display_name' => 'Delete Discount',
            'description' => "discount"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'discount-status',
            'display_name' => 'Discount status',
            'description' => "discount"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'discount-detail',
            'display_name' => 'Discount Detail',
            'description' => "discount"
        ]);

        //discount permission seeder ends here


        //programs permission seeder starts here
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'program-list',
            'display_name' => 'Program List',
            'description' => "program"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'Program-create',
            'display_name' => 'Create Program',
            'description' => "program"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'Program-edit',
            'display_name' => 'Edit programs',
            'description' => "program"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'program-delete',
            'display_name' => 'delete program',
            'description' => "program"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'program-status',
            'display_name' => 'Program status',
            'description' => "program"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'program-detail',
            'display_name' => 'Program Detail',
            'description' => "program"
        ]);

        //program permission seeder ends here

        //newspaper permission seeder starts here
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'newspaper-list',
            'display_name' => 'Newspaper List',
            'description' => "newspaper"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'newspaper-create',
            'display_name' => 'Create Newspaper',
            'description' => "newspaper"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'newspaper-edit',
            'display_name' => 'Edit Newspaper',
            'description' => "newspaper"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'newspaper-delete',
            'display_name' => 'Delete Newspaper',
            'description' => "newspaper"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'newspaper-status',
            'display_name' => 'Newspaper status',
            'description' => "newspaper"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'newspaper-detail',
            'display_name' => 'Newspaper Detail',
            'description' => "newspaper"
        ]);

        //newspaper permission seeder ends here

        //outdoor permission seeder starts here
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'outdoor-list',
            'display_name' => 'Outdoor List',
            'description' => "outdoor"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'outdoor-create',
            'display_name' => 'Create outdoor',
            'description' => "outdoor"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'outdoor-edit',
            'display_name' => 'Edit Outdoor',
            'description' => "outdoor"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'outdoor-delete',
            'display_name' => 'Delete Outdoor',
            'description' => "outdoor"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'outdoor-status',
            'display_name' => 'Outdoor status',
            'description' => "outdoor"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'outdoor-detail',
            'display_name' => 'Outdoor Detail',
            'description' => "outdoor"
        ]);

        //outdoor permission seeder ends here

        //plan order permission seeder starts here
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'plan_order-list',
            'display_name' => 'Plan order List',
            'description' => "plan_order"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'plan_order-create',
            'display_name' => 'Create Plan order',
            'description' => "plan_order"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'plan_order-edit',
            'display_name' => 'Edit Plan order',
            'description' => "plan_order"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'plan_order-delete',
            'display_name' => 'Delete Plan_order',
            'description' => "plan_order"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'plan_order-status',
            'display_name' => 'Plan order status',
            'description' => "plan_order"
        ]);
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'plan_order-detail',
            'display_name' => 'Plan order Detail',
            'description' => "plan_order"
        ]);

        //outdoor permission seeder ends here


        //admin permission seeder starts here
        Permission::create([
            'id' => Uuid::generate(4),
            'name' => 'admin',
            'display_name' => 'Admin privileges',
            'description' => "admin"
        ]);


        //admin permission seeder ends here

    }
}



<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(OAuthClientTableSeeder::class);
        //$this->call(UsersTableSeeder::class);
        $this->call(CategorySupplierTableSeeder::class);
        /*  $this->call(CategoryCityTableSeeder::class);
          $this->call(CategoryCompanyTableSeeder::class);
          $this->call(CategoryProductTableSeeder::class);
          $this->call(CategoryProfessionalTableSeeder::class);
          $this->call(CategoryTenderTableSeeder::class);
          $this->call(CategoryVacancyTableSeeder::class);
          $this->call(CreateProfileToNotHaveUsersTableSeeder::class);
          $this->call(AutoIncrementUserProformaIdTableSeeder::class);*/
        //$this->call(AutoGenerateTableSeeder::class);
        //$this->call(RoleTableSeeder::class);
        //$this->call(PermissionTableSeeder::class);
        //$this->call(UserRoleTableSeeder::class);
        //$this->call(RolePermissionTableSeeder::class);
        //$this->call(UserSubscriptionSeeeder::class);
    }
}

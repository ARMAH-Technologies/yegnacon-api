<?php

use App\Entities\Category;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;
class CategoryCompanyTableSeeder extends Seeder
{
    private $databaseSeederHelper = null;

    public function __construct(DatabaseSeederHelper $databaseSeederHelper)
    {
        $this->databaseSeederHelper = $databaseSeederHelper;
    }

    public function run()
    {
        $companyTypes = [
            'GC (General Contractors)',
            'BC (Building Contractors)',
            'RC (Road Contractors)',
            'SC (Specialized Contractors)',
            'GC (General  Consultants)',
            'BC (Building Consultants)',
            'RC (Road Consultants)',
            'SC (Specialized Consultants)'
        ];

        $companyLevels = [
            'Grade 1',
            'Grade 2',
            'Grade 3',
            'Grade 4',
            'Grade 5',
            'Grade 6',
            'Grade 7',
            'Grade 8',
            'Grade 9',
            'Grade 10'
        ];

        $this->databaseSeederHelper->categorySeeder($companyTypes, 'CompanyType');
        $this->databaseSeederHelper->categorySeeder($companyLevels, 'CompanyLevel');
    }

}
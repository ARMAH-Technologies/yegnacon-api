<?php

use App\Entities\Category;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;
use App\Entities\ProductCategory;

class CategoryProductTableSeeder extends Seeder
{
    private $databaseSeederHelper = null;

    public function __construct(DatabaseSeederHelper $databaseSeederHelper)
    {
        $this->databaseSeederHelper = $databaseSeederHelper;
    }

    public function run()
    {
        $categories = [
            'Building Construction',
            'Water Engineering Machinery and Equipment',
            'Road and Bridge Construction',
            'Building and Finishing Materials'
        ];

        $this->databaseSeederHelper->categorySeeder($categories, 'Product');
    }
}

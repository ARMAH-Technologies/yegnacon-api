<?php
use App\Entities\Category;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class CategoryCityTableSeeder extends Seeder
{
    private $databaseSeederHelper = null;

    public function __construct(DatabaseSeederHelper $databaseSeederHelper)
    {
        $this->databaseSeederHelper = $databaseSeederHelper;
    }

    public function run()
    {
        $categories = [
            'Addis Ababa',
            'Adama',
            'Awassa',
            'Bahirdar',
            'Dredawa',
            'Jimma',
            'Mekele',
            'Gambella',
            'Dessie',
            'Harar',
            'Jijga'
        ];

        $this->databaseSeederHelper->categorySeeder($categories, 'City');
    }

}
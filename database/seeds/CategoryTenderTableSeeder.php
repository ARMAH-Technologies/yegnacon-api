<?php

use App\Entities\Category;
use App\Entities\Tender;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class CategoryTenderTableSeeder extends Seeder
{
    private $databaseSeederHelper = null;

    public function __construct(DatabaseSeederHelper $databaseSeederHelper)
    {
        $this->databaseSeederHelper = $databaseSeederHelper;
    }

    public function run()
    {
        $categories = [
            'Aluminum',
            'Ceramics and Sanitaries',
            'H. Metal and industrial engineering',
            'Industrial safety equipment',
            'Road construction materials',
            'Electrical',
            'Communication equipments',
            'Building and Finishing Materials',
            'Mechanical (solar and sanitary)',
            'Construction machinery and equipment',
            'Geological',
            'Pre-engineering system',
            'Rental',
            "Water Engineering Machinery",
            "Building Construction",
            "Road and Bridge Construction",
            "Architectural and Construction Design"
        ];

        $this->databaseSeederHelper->categorySeeder($categories, 'Tender');

        foreach (Tender::all() as $tender) {
            $category = Category::where('category', $tender->category)
                ->where('type', 'Tender')
                ->first();
            $tender->category_id = $category->id;
            $tender->save();
        }

        Schema::table('tenders', function ($table) {
            $table->dropColumn('category');
        });
    }
}
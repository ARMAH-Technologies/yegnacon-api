<?php
use App\Entities\Category;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class CategoryVacancyTableSeeder extends Seeder
{
    private $databaseSeederHelper = null;

    public function __construct(DatabaseSeederHelper $databaseSeederHelper)
    {
        $this->databaseSeederHelper = $databaseSeederHelper;
    }

    public function run()
    {
        $categories = [
            "Admin, Secretarial and Clerical",
            "Agriculture",
            "Automotive",
            "Insurance and Banking",
            "Biotech and Pharmaceutical",
            "Business and Management",
            "Business Development",
            "Consultancy and Training",
            "Creative Arts",
            "Customer Service",
            "Economics",
            "Education",
            "Engineering and Construction",
            "Event Management ",
            "FMCG, Retail and Wholesale",
            "Health Care",
            "Hospitality",
            "Human Resources",
            "Information Technology",
            "Inventory and Stock",
            "Legal",
            "Logistics and Transportation",
            "Management", "Manufacturing",
            "Sales and Marketing",
            "Media and Journalism",
            "Natural Resources and Environment",
            "Natural Sciences",
            "Purchasing and Procurement",
            "Quality Control and Safety",
            "Research ",
            "Science and Technology",
            "Social Sciences and Community",
            "Telecommunications",
            "Water and Sanitation"
        ];

        $this->databaseSeederHelper->categorySeeder($categories, 'Vacancy');
    }

}
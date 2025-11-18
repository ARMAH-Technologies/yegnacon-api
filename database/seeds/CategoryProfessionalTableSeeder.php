<?php

use App\Entities\Category;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;
class CategoryProfessionalTableSeeder extends Seeder
{
    private $databaseSeederHelper = null;

    public function __construct(DatabaseSeederHelper $databaseSeederHelper)
    {
        $this->databaseSeederHelper = $databaseSeederHelper;
    }

    public function run()
    {
        $professionalExperiences = [
            'Entry Level(Fresh Graduate)',
            'Junior Level (1 - 2 Years',
            'Mid Level (2 - 5 Years',
            'Senior Level (5+ Years)'
        ];

        $professionalEducations = [
            'Certificate',
            'Diploma',
            'BSc',
            'BA',
            'MSc',
            'PHD'
        ];

        $this->databaseSeederHelper->categorySeeder($professionalExperiences, 'ProfessionalExperience');
        $this->databaseSeederHelper->categorySeeder($professionalEducations, 'ProfessionalEducation');

    }

}
<?php

use App\Entities\ActiveProject;
use App\Entities\Address;
use App\Entities\Category;
use App\Entities\Comment;
use App\Entities\Consultant;
use App\Entities\Contractor;
use App\Entities\ContractorAndConsultant;
use App\Entities\Education;
use App\Entities\Experience;
use App\Entities\File;
use App\Entities\News;
use App\Entities\Product;
use App\Entities\Professional;
use App\Entities\Project;
use App\Entities\ProjectOwner;
use App\Entities\Skill;
use App\Entities\Supplier;
use App\Entities\Tender;
use App\Entities\Users\User;
use App\Entities\Vacancy;
use Illuminate\Database\Seeder;

class AutoGenerateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(User::class, 30)->create(['profile_type' => 'Contractor']);

        factory(User::class, 30)->create(['profile_type' => 'Consultant']);

        factory(User::class, 30)->create(['profile_type' => 'ContractorAndConsultant']);

        factory(User::class, 30)->create(['profile_type' => 'Supplier']);

       factory(User::class, 30)->create(['profile_type' => 'Professional']);

       factory(User::class, 30)->create(['profile_type' => 'ProjectOwner']);

        foreach (User::all() as $user) {
            if ($user->profile_type === "Professional") {
                factory(File::class, 1)->create(['item_id' => $user->id,'file_path' => 'uploads/profile',
                    'extension' => '.png', 'original' => 'default_user.png', 'thumbnail' => 'default_user.png',
                    'large_image' => 'default_user.png']);
               factory(Professional::class, 1)->create(['user_id' => $user->id]);
            } else if ($user->profile_type === "Contractor") {
                factory(File::class, 1)->create(['item_id' => $user->id,'file_path' => 'uploads/profile',
                    'extension' => '.png', 'original' => 'default_user.png', 'thumbnail' => 'default_user.png',
                    'large_image' => 'default_user.png']);
                factory(Contractor::class, 1)->create(['user_id' => $user->id]);
            } else if ($user->profile_type === "Consultant") {
                factory(File::class, 1)->create(['item_id' => $user->id,'file_path' => 'uploads/profile',
                    'extension' => '.png', 'original' => 'default_user.png', 'thumbnail' => 'default_user.png',
                    'large_image' => 'default_user.png']);
                factory(Consultant::class, 1)->create(['user_id' => $user->id]);
            } else if ($user->profile_type === "ContractorAndConsultant") {
                factory(File::class, 1)->create(['item_id' => $user->id,'file_path' => 'uploads/profile',
                    'extension' => '.png', 'original' => 'default_user.png', 'thumbnail' => 'default_user.png',
                    'large_image' => 'default_user.png']);
               factory(ContractorAndConsultant::class, 1)->create(['user_id' => $user->id]);
            } else if ($user->profile_type === "Supplier") {
                factory(File::class, 1)->create(['item_id' => $user->id,'file_path' => 'uploads/profile',
                    'extension' => '.png', 'original' => 'default_user.png', 'thumbnail' => 'default_user.png',
                    'large_image' => 'default_user.png']);
               factory(Supplier::class, 1)->create(['user_id' => $user->id]);
            } else if ($user->profile_type === "ProjectOwner") {
                factory(File::class, 1)->create(['item_id' => $user->id,'file_path' => 'uploads/profile',
                    'extension' => '.png', 'original' => 'default_user.png', 'thumbnail' => 'default_user.png',
                    'large_image' => 'default_user.png']);
               factory(ProjectOwner::class, 1)->create(['user_id' => $user->id]);
            }

            factory(Address::class, 1)->create(['item_id' => $user->id, 'item_type' => 'User']);
        }

       foreach (Contractor::all() as $contractor) {
           factory(Project::class, 5)->create(['profile_id' => $contractor->id, 'profile_type' => 'Contractor']);
           factory(Vacancy::class, 2)->create(['item_id' => $contractor->id, 'item_type' => 'Contractor']);
           factory(Tender::class, 2)->create(['item_id' => $contractor->id, 'item_type' => 'Contractor']);
        }

        foreach (Consultant::all() as $consultant) {
           factory(Project::class, 5)->create(['profile_id' => $consultant->id, 'profile_type' => 'Consultant']);
       }

       foreach (ContractorAndConsultant::all() as $contractorAndConsultant) {
           factory(Project::class, 5)->create(['profile_id' => $contractorAndConsultant->id,
                'profile_type' => 'ContractorAndConsultant']);
       }

       foreach (Professional::all() as $professional) {
            factory(Education::class, 5)->create(['professional_id' => $professional->id]);
            factory(Experience::class, 5)->create(['professional_id' => $professional->id]);
           factory(Skill::class, 5)->create(['professional_id' => $professional->id]);
       }

       foreach (Supplier::all() as $supplier) {
           factory(Product::class, 3)->create(['supplier_id' => $supplier->id]);
        }

       foreach (ProjectOwner::all() as $projectOwner) {
            factory(ActiveProject::class, 2)->create(['project_owner_id' => $projectOwner->id]);
        }

        foreach (Product::all() as $product) {
            factory(File::class,1)->create(['item_id' => $product->id,'file_path' => 'uploads/product',
                'extension' => '.png', 'original' => 'default_product.png', 'thumbnail' => 'default_product.png',
                'large_image' => 'default_product.png']);
        }

       $categoryIds = [];
       $categories = Category::all();
       for ($i = 0; $i < $categories->count(); $i++) {
           $categoryIds[$i] = $categories[$i]->id;
       }

        foreach (Supplier::all() as $supplier) {
               $randomId = $categoryIds[array_rand($categoryIds, 1)];
               $supplier->categories()->sync([$randomId]);
        }

        factory(News::class, 10)->create();

        foreach (News::all() as $news) {
            factory(Comment::class,5)->create(['news_id' => $news->id]);
            factory(File::class,1)->create(['item_id' => $news->id,'file_path' => 'uploads/news',
                'extension' => '.png', 'original' => 'default_news.png', 'thumbnail' => 'default_news.png',
                'large_image' => 'default_news.png']);
        }
    }
}

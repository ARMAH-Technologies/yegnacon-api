<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Entities\ActiveProject;
use App\Entities\Address;
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
use Webpatser\Uuid\Uuid;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'id' => Uuid::generate(4),
        'name' => $faker->company,
        'email' => $faker->email,
        'password' => bcrypt('123'),
        'profile_type' => '',
        'status' => 'active'
    ];
});

$factory->define(Contractor::class, function (Faker\Generator $faker) {
    $types = ['GC (General Contractor)', 'BC (Building Contractor)', 'RC (Road Contractor)'];
    $levels = ['Level - 1', 'Level - 2', 'Level - 3', 'Level - 4', 'Level - 5', 'Level - 6', 'Level - 7'];
    return [
        'id' => Uuid::generate(4),
        'user_id' => '',
        'type' => $types[array_rand($types, 1)],
        'level' => $levels[array_rand($levels, 1)],
        'established_year' => $faker->date(),
        'description' => $faker->text(),
    ];
});

$factory->define(Consultant::class, function (Faker\Generator $faker) {
    $types = ['GC (General Consultant)', 'BC (Building Consultant)', 'RC (Road Consultant)'];
    $levels = ['Level - 1', 'Level - 2', 'Level - 3', 'Level - 4', 'Level - 5', 'Level - 6', 'Level - 7'];
    return [
        'id' => Uuid::generate(4),
        'user_id' => '',
        'type' => $types[array_rand($types, 1)],
        'level' => $levels[array_rand($levels, 1)],
        'established_year' => $faker->date(),
        'description' => $faker->text(),
    ];
});

$factory->define(ContractorAndConsultant::class, function (Faker\Generator $faker) {
    $types = ['GC (General Contractor and Consultant)', 'BC (Building Contractor and Consultant)', 'RC (Road Contractor and Consultant)'];
    $levels = ['Level - 1', 'Level - 2', 'Level - 3', 'Level - 4', 'Level - 5', 'Level - 6', 'Level - 7'];
    return [
        'id' => Uuid::generate(4),
        'user_id' => '',
        'type' => $types[array_rand($types, 1)],
        'level' => $levels[array_rand($levels, 1)],
        'established_year' => $faker->date(),
        'description' => $faker->text(),
    ];
});

$factory->define(Supplier::class, function (Faker\Generator $faker) {
    return [
        'id' => Uuid::generate(4),
        'user_id' => '',
        'established_year' => $faker->date(),
        'description' => $faker->text(),
    ];
});
$factory->define(Professional::class, function (Faker\Generator $faker) {
    $gender = ['Male', 'Female'];
    return [
        'id' => Uuid::generate(4),
        'user_id' => '',
        'professional_title' => $faker->text(10),
        'birth_date' => $faker->date(),
        'gender' => $gender[array_rand($gender, 1)],
        'nationality' => $faker->country(),
        'biography' => $faker->text(),
    ];
});
$factory->define(ProjectOwner::class, function (Faker\Generator $faker) {
    $type = ['Ngo', 'Government', 'Private'];
    return [
        'id' => Uuid::generate(4),
        'user_id' => '',
        'type' => $type[array_rand($type, 1)]
    ];
});
$factory->define(Experience::class, function (Faker\Generator $faker) {
    return [
        'id' => Uuid::generate(4),
        'professional_id' => '',
        'company' => $faker->company,
        'position' => $faker->text(10),
        'description' => $faker->realText(200),
        'started_date' => $faker->date(),
        'ended_date' => $faker->date(),
    ];
});
$factory->define(Education::class, function (Faker\Generator $faker) {
    $study_field = ['Civil Engineering', 'Urban', 'Road Construction'];
    $grad_level = ['BSc.', 'MSc.'];
    return [
        'id' => Uuid::generate(4),
        'professional_id' => '',
        'study_field' => $study_field[array_rand($study_field, 1)],
        'grad_level' => $grad_level[array_rand($grad_level, 1)],
        'school_name' => $faker->text(20),
        'started_date' => $faker->date(),
        'ended_date' => $faker->date()
    ];
});
$factory->define(Skill::class, function (Faker\Generator $faker) {
    return [
        'id' => Uuid::generate(4),
        'professional_id' => '',
        'skill' => $faker->text(10)
    ];
});
$factory->define(Address::class, function (Faker\Generator $faker) {
    return [
        'id' => Uuid::generate(4),
        'item_id' => '',
        'item_type' => '',
        'phone_number_1' => $faker->phoneNumber,
        'phone_number_2' => $faker->phoneNumber,
        'website' => $faker->companyEmail,
        'country' => $faker->country,
        'city' => $faker->city,
        'sub_city' => $faker->city,
        'house_no' => $faker->streetName,
        'specific_address' => $faker->streetAddress,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'facebook_link' => $faker->companyEmail,
        'twitter_link' => $faker->companyEmail,
        'linkidin_link' => $faker->companyEmail,
        'google_link' => $faker->companyEmail,
        'instagram_link' => $faker->companyEmail
    ];
});
$factory->define(Project::class, function (Faker\Generator $faker) {
    $category = ['Architectural and Construction Design', 'Water Engineering Machinery ', 'Building Construction',
        'Building and Finishing Materials', 'Road and Bridge Construction'];
    $elapsed_time = ['2 year', '1 year', '3 year'];
    return [
        'id' => Uuid::generate(4),
        'profile_id' => '',
        'profile_type' => '',
        'name' => $faker->text(15),
        'category' => $category[array_rand($category, 1)],
        'client' => $faker->text(10),
        'description' => $faker->realText(200),
        'elapsed_time' => $elapsed_time[array_rand($elapsed_time, 1)]
    ];
});
$factory->define(File::class, function (Faker\Generator $faker) {
    return [
        'id' => Uuid::generate(4),
        'item_id' => '',
        'file_path' => '',
        'extension' => '',
        'original' => '',
        'thumbnail' => '',
        'large_image' => ''
    ];
});
$factory->define(Product::class, function (Faker\Generator $faker) {
    $category = ['Water Engineering Machinery and Equipment', 'Building Construction', 'Building and Finishing Materials',
        'Road and Bridge Construction'];
    $units = ['quintal', 'm3', 'm2', 'm', 'mm', 'gallon', 'kg'];
    return [
        'id' => Uuid::generate(4),
        'supplier_id' => '',
        'name' => $faker->text(10),
        'category' => $category[array_rand($category, 1)],
        'price' => $faker->numberBetween(10, 14000),
        'quantity' => $faker->numberBetween(300, 1200),
        'unit' => $units[array_rand($units, 1)],
        'description' => $faker->realText(200)
    ];
});
$factory->define(Vacancy::class, function (Faker\Generator $faker) {
    $category = ['Architectural and Construction Design', 'Water Engineering Machinery ', 'Building Construction',
        'Building and Finishing Materials', 'Road and Bridge Construction'];
    $contract = ['Full time', 'Contract'];
    $education_level = ['Certificate', 'Diploma', 'BSc.', 'MSc.'];
    $experience = ['Entry Level (Fresh Graduate)',
        'Junior Level (1+ - 2 years experience)',
        'Mid Level ( 2+ - 5 years expedience)',
        'Senior Level (5+ years expedience)',
        'Managerial Level (Manager, Supervisor, Director)'];
    return [
        'id' => Uuid::generate(4),
        'item_id' => '',
        'item_type' => '',
        'title' => $faker->text(10),
        'category' => $category[array_rand($category, 1)],
        'contract' => $contract[array_rand($contract, 1)],
        'education_level' => $education_level[array_rand($education_level, 1)],
        'experience' => $experience[array_rand($experience, 1)],
        'salary' => $faker->numberBetween(800, 14000),
        'work_place' => $faker->city,
        'description' => $faker->realText(200),
        'closing_date' => $faker->date(),
        'status' => 'active'
    ];
});
$factory->define(Tender::class, function (Faker\Generator $faker) {
    $tender_title = ['Robe Town Internal Asphalt Road Project', ' supply of GI Pipes of different sizes (2.5)', 'Alemgena Town Internal Asphalt Road Project', ' temporary shed at Bulbula site ', 'Purchase of Solar Boilers'];
    $category = ['Architectural and Construction Design', 'Water Engineering Machinery ', 'Building Construction', 'Building and Finishing Materials', 'Road and Bridge Construction'];
    return [
        'id' => Uuid::generate(4),
        'item_id' => '',
        'item_type' => '',
        'title' => $tender_title[array_rand($tender_title, 1)],
        'category' => $category[array_rand($category, 1)],
        'document_price' => $faker->numberBetween(50, 250),
        'bid_bond' => $faker->numberBetween(5000, 20000),
        'opening_date' => $faker->date(),
        'closing_date' => $faker->date(),
        'description' => $faker->realText(200),
        'status' => 'active'
    ];
});
$factory->define(ActiveProject::class, function (Faker\Generator $faker) {
    $project_name = ['Robe Town Internal Asphalt Road Project', ' supply of GI Pipes of different sizes (2.5)',
        'Alemgena Town Internal Asphalt Road Project', ' temporary shed at Bulbula site ', 'Purchase of Solar Boilers'];
    $category = ['Small Scale Project', 'Medium Scale project', 'Large Scale Project'];
    $expected_time = ['1 year', '2 year', '3 year', '6 month'];
    $types = ['GC (General Contractor)', 'BC (Building Contractor)', 'RC (Road Contractor)'];
    $project_options = ['With Raw Material', 'Without Raw Material'];
    return [
        'id' => Uuid::generate(4),
        'project_owner_id' => '',
        'name' => $project_name[array_rand($project_name, 1)],
        'type' => $types[array_rand($types, 1)],
        'category' => $category[array_rand($category, 1)],
        'project_option' => $project_options[array_rand($project_options, 1)],
        'location' => $faker->country,
        'expected_time' => $expected_time[array_rand($expected_time, 1)],
        'description' => $faker->realText(200),
        'status' => 'active'
    ];
});
$factory->define(News::class, function (Faker\Generator $faker) {
    return [
        'id' => Uuid::generate(4),
        'title' => $faker->realText(50),
        'description' => $faker->realText(1000),
    ];
});
$factory->define(Comment::class, function (Faker\Generator $faker) {
    return [
        'id' => Uuid::generate(4),
        'name' => $faker->name,
        'email' => $faker->email,
        'comment' => $faker->realText(50),
    ];
});



<?php
use App\Entities\Category;
use Webpatser\Uuid\Uuid;

/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 10/4/2016
 * Time: 4:40 PM
 */
class DatabaseSeederHelper
{
    public function categorySeeder($categories, $type)
    {
        foreach ($categories as $category) {
            $dbCategory = Category::where('category', $category)
                ->where('type', $type)
                ->first();

            if (!$dbCategory) {
                $tmp = new Category();
                $tmp->id = Uuid::generate(4);
                $tmp->category = $category;
                $tmp->type = $type;
                $tmp->save();
            } else {
                $dbCategory = Category::find($dbCategory->id);
                $dbCategory->type = $type;
                $dbCategory->save();
            }
        }
    }
}
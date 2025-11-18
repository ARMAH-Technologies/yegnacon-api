<?php
/**
 * Created by PhpStorm.
 * User: yaye
 * Date: 9/29/2016
 * Time: 2:18 PM
 */

namespace App\Repositories;

use App\Entities\Categories_users;
use App\Entities\Category;
use App\Entities\Users\User;
use App\Entities\Tender;
use DB;
use App\CustomCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class UserCategoryRepository
{
    public function getAllCategories()
    {
        $categories = Category::all();

        return $categories;
    }
    public function getUserCategories($user_id)
    {
        $userCategories = User::find($user_id)->categories()->get();

        return $userCategories;
    }

    public function store($input, $user_id)
    {
        $this->detachAllUserCategories($user_id);

        $this->attachToCategories($user_id, $input->category_ids);

        return $this->getUserCategories($user_id);
    }

    private function attachToCategories($userId, $category_ids)
    {
        User::find($userId)->categories()->attach($category_ids);
    }

    private function detachAllUserCategories($userId)
    {
        User::find($userId)->categories()->detach();
    }
    public function getUserTenders($user_id)

    {
        $category_ids=array();
        //$tenders=array();
        $categories = User::find($user_id)->categories()->get();
        // return $categories;
        foreach ($categories as $category) {
           array_push( $category_ids,$category->id);
    }


            $tenders = Tender::whereIn('category_id',$category_ids)->get();
            ///array_push($tenders,'Tenders',$tender);
        return $tenders;
    }

}
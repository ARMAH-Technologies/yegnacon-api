<?php
/**
 * Created by PhpStorm.
 * User: wonde
 * Date: 9/29/2016
 * Time: 11:27 AM
 */

namespace App\Repositories;

use App\Entities\Category;
use App\Entities\Users\User;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class CategoryRepository
{
    use RepositoryHelperTrait;

    public function getCategories($request)
    {
        return Category::filterByType($request)->orderBy('category', 'asc')->get();
    }

    public function getUserCategories($request, $user_id)
    {
        $profile = $this->getUserProfile($user_id);

        if ($request->get('type') === 'Tender') {
            return $profile->tenderCategories()->get();
        } else if ($request->get('type') === 'Proforma') {
            return $profile->proformaCategories()->get();
        }
    }

    public function store($input)
    {
        $category = $this->save($input->category);

        return $category;
    }

    public function update($input)
    {
        $category = $this->save($input->category);

        return $category;
    }

    private function save($input)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $category = category::find($id);
            $category->category = $input['category'];
            $category->type = $input['type'];
            $category->save();
        } else {
            $category = new category();
            $category->id = $id = Uuid::generate(4);
            $category->category = $input['category'];
            $category->type = $input['type'];
            $category->save();
        }

        return Category::find($id);
    }

    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();

        return $category;
    }

    public function attachUserToCategories($input, $user_id)
    {
        $this->detachAllUserCategories($user_id);

        $this->attachToCategories($user_id, $input->category_ids);

        $category_type = Category::find($input->category_ids[0])->type;
        $profile = $this->getUserProfile($user_id);

        if ($category_type === 'Tender') {
            return $profile->tenderCategories()->get();
        } else if ($category_type === 'Supplier') {
            return $profile->proformaCategories()->get();
        }
    }

    private function attachToCategories($userId, $category_ids)
    {
        $profile = $this->getUserProfile($userId);

        $profile->tenderCategories()->attach($category_ids, ['type' => 'Tender']);
    }

    private function detachAllUserCategories($userId)
    {
        $profile = $this->getUserProfile($userId);

        $profile->tenderCategories()->detach();
    }

}
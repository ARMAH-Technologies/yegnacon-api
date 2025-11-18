<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 2/25/2016
 * Time: 8:21 PM
 */

namespace App\Repositories;


use App\Company;
use App\Entities\Category;
use App\SupplierCategory;
use App\Entities\ProductCategory;

class BaseRepository
{
    public function getAllCategories()
    {
        return Category::all()->sortBy('category');
    }

    public function getProductCategories()
    {
        return ProductCategory::all()->sortBy('category');
    }

}
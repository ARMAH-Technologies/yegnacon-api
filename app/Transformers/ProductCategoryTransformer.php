<?php

namespace App\Transformers;

use App\Entities\Category;
use League\Fractal\TransformerAbstract;
use App\Entities\ProductCategory;

class ProductCategoryTransformer extends TransformerAbstract
{
    public function transform(ProductCategory $category)
    {
        return [
            'id' => $category->id,
            'category' => $category->category
        ];
    }
}
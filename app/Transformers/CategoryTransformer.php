<?php

namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use App\Entities\Category;

use App\Entities\Mytender;
class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $category)
    {
        return [
            'id' =>$category->id,
            'category' =>$category->category,
            'type' =>$category->type
        ];
    }
}
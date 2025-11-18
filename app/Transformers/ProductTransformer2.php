<?php

namespace App\Transformers;

use App\Entities\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer2 extends TransformerAbstract
{


    public function transform(Product $product)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'category' => $product->category,
            'quantity' => $product->quantity,
            'unit' => $product->unit,
            'price' => $product->price,
            'description' => $product->description
        ];
    }


}
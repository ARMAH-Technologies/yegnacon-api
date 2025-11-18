<?php

namespace App\Transformers;

use App\Entities\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['supplier', 'file'];

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

    public function includeSupplier(Product $product){
        if ($product->supplier) {
            return $this->item($product->supplier, new SupplierTransformer(false));
        }
    }

    public function includeFile(Product $product){
        if ($product->file){
            return $this->item($product->file, new FileTransformer());
        }
    }
}
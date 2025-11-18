<?php

namespace App\Transformers;

use App\Entities\Supplier;
use League\Fractal\TransformerAbstract;
use App\Entities\Users\User;

class SupplierTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['category','product'];

    protected $includeDetail;

    public function __construct($includeDetail = true)
    {
        $this->includeDetail = $includeDetail;
    }

    public function transform(Supplier $supplier)
    {
        return [
            'id' => $supplier->id,
            'supplier_id'=> $supplier->user->id,
            'supplier_name' => $supplier->user->name,
            'type' => $supplier->type,
            'established_year' => $supplier->established_year,
            'description' => $supplier->description
        ];
    }

    public function includeCategory(Supplier $supplier)
    {
        return $this->collection($supplier->proformaCategories, new CategoryTransformer());
    }

    public function includeProduct(Supplier $supplier)
    {
        if ($this->includeDetail) {
            return $this->collection($supplier->products, new ProductTransformer2());
        }
    }
}
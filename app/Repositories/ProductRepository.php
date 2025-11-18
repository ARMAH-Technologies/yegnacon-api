<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 2/25/2016
 * Time: 8:35 PM
 */

namespace App\Repositories;

use App\Entities\Supplier;
use App\Entities\Product;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class ProductRepository
{
    use RepositoryHelperTrait;

    public function getProductsCount(){
        $count = Product::count();
        $supplierCount = Supplier::with('products')->count();
        $response = array("product"=>array());
        $response["product"]["itemCount"] =  $count;
        $response["product"]["suppliersCount"] = $supplierCount;
        return $response;
    }

    public function getAllProducts(Request $request, $n)
    {
        return Product::searchProduct($request)->filterByCategory($request)->latest()->paginate($n);
    }

    public function getUserProducts($user_id, $n)
    {
        $supplier_id = $this->getUserProfile($user_id)->id;

        return Product::where('supplier_id', $supplier_id)->latest()->paginate($n);
    }

    public function getProductDetail($productId)
    {
        return Product::find($productId);
    }

    public function store($input, $userId)
    {
        $supplierId = $this->getUserProfile($userId)->id;

        $product = $this->saveProduct($input->product, $supplierId);

        return $product;
    }

    public function update($input)
    {
        $product = $this->saveProduct($input->product);

        return $product;
    }

    public function delete($productId)
    {
        $product = Product::find($productId);
        $product->delete();

        return $product;
    }

    private function saveProduct($input, $supplier_id = null)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $project = Product::find($id);
            $project->name = $input['name'];
            $project->category = isset($input['category']) ? $input['category'] : $project->category;
            $project->quantity = isset($input['quantity']) ? $input['quantity'] : $project->quantity;
            $project->unit = isset($input['unit']) ? $input['unit'] : $project->unit;
            $project->price = isset($input['price']) ? $input['price'] : $project->price;
            $project->description = isset($input['description']) ? $input['description'] : $project->description;
            $project->save();
        } else {
            $project = new Product();
            $project->id = $id = Uuid::generate(4);
            $project->supplier_id = $supplier_id;
            $project->name = $input['name'];
            $project->category = isset($input['category']) ? $input['category'] : null;
            $project->quantity = isset($input['quantity']) ? $input['quantity'] : null;
            $project->unit = isset($input['unit']) ? $input['unit'] : null;
            $project->price = isset($input['price']) ? $input['price'] : null;
            $project->description = isset($input['description']) ? $input['description'] : null;
            $project->save();
        }

        return Product::find($id);
    }

}
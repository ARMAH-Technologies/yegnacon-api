<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Transformers\ProductTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use Helpers;

    protected $productRepository;
    protected $per_page = 7;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        $products = $this->productRepository->getAllProducts($request, $this->per_page);

        $response = $this->response->paginator($products, new ProductTransformer());

        return $response;
    }

    public function store(Request $request)
    {
        $userId = $user = app('Dingo\Api\Auth\Auth')->user()->id;

        $product = $this->productRepository->store($request , $userId);

        $response = $this->response->item($product, new ProductTransformer());

        return $response;
    }

    public function show($productId)
    {
        $product = $this->productRepository->getProductDetail($productId);

        $response = $this->response->item($product, new ProductTransformer());

        return $response;
    }

    public function update(Request $request)
    {
        $product = $this->productRepository->update($request);

        $response = $this->response->item($product, new ProductTransformer());

        return $response;
    }

    public function destroy($productId)
    {
        $product = $this->productRepository->delete($productId);

        $response = $this->response->item($product, new ProductTransformer());

        return $response;
    }

    public function getUserProducts($userId)
    {
        $products = $this->productRepository->getUserProducts($userId, $this->per_page);

        $response = $this->response->paginator($products, new ProductTransformer());

        return $response;
    }
    public function getStatistics(){
        $productCount = $this->productRepository->getProductsCount();
        return $productCount;
    }
}

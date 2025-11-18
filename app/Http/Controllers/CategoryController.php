<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Transformers\CategoryTransformer;
use Dingo\Api\Routing\Helpers;

class CategoryController extends Controller
{
    use Helpers;
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;

    }

    public function getCategories(Request $request)
    {
        $categories = $this->categoryRepository->getCategories($request);

        $response = $this->response->collection($categories, new CategoryTransformer());

        return $response;
    }

    public function store(Request $request)
    {
        $category = $this->categoryRepository->store($request);

        $response = $this->response->item($category , new CategoryTransformer());

        return $response;
    }

    public function attachUserToCategories(Request $request,$user_id)
    {
        $categories = $this->categoryRepository->attachUserToCategories($request, $user_id);

        $response = $this->response->collection($categories , new CategoryTransformer());

        return $response;
    }

    public function update(Request $request)
    {
        $category = $this->categoryRepository->update($request);

        $response = $this->response->item($category , new CategoryTransformer());

        return $response;
    }

    public function destroy($id)
    {
        $category = $this->categoryRepository->delete($id);

        $response = $this->response->item($category , new CategoryTransformer());

        return $response;
    }

    public function getUserCategories(Request $request, $user_id)
    {
        $categories = $this->categoryRepository->getUserCategories($request,$user_id);

        $response = $this->response->collection($categories, new CategoryTransformer());

        return $response;
    }
}

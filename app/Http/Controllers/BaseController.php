<?php

namespace App\Http\Controllers;

use App\Repositories\BaseRepository;
use App\Transformers\CategoryTransformer;
use Dingo\Api\Routing\Helpers;
use App\Transformers\ProductCategoryTransformer;

class BaseController extends Controller
{
    use Helpers;

    protected $baseRepository;

    public function __construct(BaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    public function getAllCategories()
    {
        $categories = $this->baseRepository->getAllCategories();

        $response = $this->response->collection($categories, new CategoryTransformer());

        return $response;
    }

    public function getProductCategories()
    {
        $categories = $this->baseRepository->getProductCategories();

        $response = $this->response->collection($categories, new ProductCategoryTransformer());

        return $response;
    }
}

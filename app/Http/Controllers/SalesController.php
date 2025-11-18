<?php
/**
 * Created by PhpStorm.
 * User: yido
 * Date: 8/14/16
 * Time: 12:22 PM
 */

namespace App\Http\Controllers;


use App\Repositories\SalesRepository;
use App\Transformers\SalesTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    use Helpers;

    protected $salesRepository;

    public function __construct(SalesRepository $salesRepository)
    {
        $this->salesRepository = $salesRepository;
    }

    public function index(Request $request)
    {

        $sales = $this->salesRepository->getAllSales();

        $response = $this->response->collection($sales, new SalesTransformer());


        return $response;
    }

}
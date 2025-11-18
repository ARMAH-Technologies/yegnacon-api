<?php

namespace App\Http\Controllers;

use App\Repositories\NewsRepository;
use App\Transformers\NewsDetailTransformer;
use App\Transformers\NewsTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    use Helpers;

    protected $newsRepository;
    protected $per_page = 10;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function index()
    {
        $news = $this->newsRepository->getAllNews($this->per_page);

        $response = $this->response->paginator($news, new NewsTransformer());

        return $response;
    }

    public function store(Request $request)
    {
        $news = $this->newsRepository->store($request);

        $response = $this->response->item($news, new NewsTransformer());

        return $response;
    }

    public function show($newsId)
    {
        $news = $this->newsRepository->getNewsDetail($newsId);

        $response = $this->response->item($news, new NewsDetailTransformer());

        return $response;
    }

    public function update(Request $request)
    {
        $news = $this->newsRepository->update($request);

        $response = $this->response->item($news, new NewsTransformer());

        return $response;
    }

    public function destroy($newsId)
    {
        $news = $this->newsRepository->delete($newsId);

        $response = $this->response->item($news, new NewsTransformer());

        return $response;
    }

    public function storeComment(Request $request, $newsId)
    {
        $news = $this->newsRepository->storeComment($request, $newsId);

        $response = $this->response->item($news, new NewsDetailTransformer());

        return $response;
    }
}

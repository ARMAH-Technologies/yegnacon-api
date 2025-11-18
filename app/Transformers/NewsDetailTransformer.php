<?php

namespace App\Transformers;

use App\Entities\News;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class NewsDetailTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

    protected $defaultIncludes = ['comments', 'files'];

    public function transform(News $news)
    {
        return [
            'id' => $news->id,
            'title' => $news->title,
            'description' => $news->description,
            'created_at' => Carbon::parse($news->created_at)->toFormattedDateString(),
            'totalComments' => $this->countNewsComments($news),
            'status' => $news->status
        ];
    }

    public function includeFiles(News $news)
    {
        return $this->collection($news->files->sortByDesc('created_at'), new FileTransformer());
    }

    public function includeComments(News $news)
    {
        return $this->collection($news->comments->sortByDesc('created_at'), new CommentTransformer());
    }
}
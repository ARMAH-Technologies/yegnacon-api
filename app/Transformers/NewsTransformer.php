<?php
namespace App\Transformers;

use App\Entities\News;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class NewsTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

    public function transform(News $news)
    {
        return [
            'id' => $news->id,
            'title' => $news->title,
            'description' => $news->description,
            'totalComments' => $this->countNewsComments($news),
            'created_at' => Carbon::parse($news->created_at)->toFormattedDateString(),
            'image' =>  $this->getItemLogo($news, 'News'),
            'status' => $news->status
        ];
    }
}
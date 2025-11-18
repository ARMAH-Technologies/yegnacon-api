<?php
namespace App\Transformers;

use App\Entities\Comment;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

    public function transform(Comment $comment)
    {
        return [
            'id' => $comment->id,
            'comment' => $comment->comment,
            'name' => $comment->name,
            'email' => $comment->email,
            'created_at' => Carbon::parse($comment->created_at)->toDateTimeString()
        ];
    }
}
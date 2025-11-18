<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 2/25/2016
 * Time: 8:21 PM
 */

namespace App\Repositories;

use App\Entities\Comment;
use App\Entities\News;
use Webpatser\Uuid\Uuid;

class NewsRepository
{
    use RepositoryHelperTrait;
    use StatusTrait;

    public function getAllNews($n)
    {
        return News::latest()->paginate($n);
    }

    public function getNewsDetail($newsId)
    {
        return News::find($newsId);
    }

    public function store($input)
    {
        $news = $this->saveNews($input->news);

        return $news;
    }

    public function storeComment($input, $newsId)
    {
        $news = $this->saveComment($input->comment, $newsId);

        return $news;
    }

    public function update($input)
    {
        $news = $this->saveNews($input->news);

        return $news;
    }

    public function delete($newsId)
    {
        $news = News::find($newsId);
        $news->delete();

        return $news;
    }

    private function saveNews($input)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $news = News::find($id);
            $news->title = $input['title'];
            $news->description = $input['description'];
            $news->save();
        } else {
            $news = new News();
            $news->id = $id = Uuid::generate(4);
            $news->title = $input['title'];
            $news->description = $input['description'];
           // $news->status = $this->newsStatus;
            $news->save();
        }

        return News::find($id);
    }

    private function saveComment($input, $newsId)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $comment = Comment::find($id);
            $comment->comment = $input['comment'];
            $comment->name = $input['name'];
            $comment->email = $input['email'];
            $comment->save();
        } else {
            $comment = new Comment();
            $comment->id = $id = Uuid::generate(4);
            $comment->news_id = $newsId;
            $comment->comment = $input['comment'];
            $comment->name = $input['name'];
            $comment->email = $input['email'];
            $comment->save();
        }

        return News::find($newsId);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 2/25/2016
 * Time: 8:21 PM
 */

namespace App\Repositories;


use App\Comment;
use App\Contractor;
use App\News;
use App\Supplier;
use App\User;
use Auth;

class CommentRepository
{
    public function getAllComments($news_id)
    {
        $newsComments = Comment::where("news_id",$news_id)->all();
        return $newsComments;
    }

    public function storeCommentNews($input,$id)
    {
        $comment =  News::find($id)->comments()->create([
            'name' => $input['name'],
            'email' => $input['email'],
            'type' => $input['type'],
            'comment' => $input['comment']
        ]);

        return $comment->id;
    }

    public function storeCommentNewsTwo($input,$id)
    {
       // $currentUser = User::find(Auth::user()->id);
        $comment =  News::find($id)->comments()->create([
            'name' =>  "sami",
            'email' =>  "sami@gmail.com",
            'type' => $input['type'],
            'comment' => $input['comment']
        ]);

        return $comment->id;
    }


    public function storeCommentSupplier($input,$id)
    {
        $currentUser = User::find(Auth::user()->id);
        $comment =  Supplier::find($id)->comments()->create([
            'name' => $currentUser->name,
            'email' =>  $currentUser->email,
            'type' => $input['type'],
            'comment' => $input['comment']
        ]);

        return $comment->id;
    }
    public function storeCommentContractor($input,$id)
    {
        $currentUser = User::find(Auth::user()->id);
        $comment =  Contractor::find($id)->comments()->create([
            'name' => $currentUser->name,
            'email' =>  $currentUser->email,
            'type' => $input['type'],
            'comment' => $input['comment']
        ]);

        return $comment->id;
    }

}
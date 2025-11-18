<?php

namespace App\Http\Controllers;

use App\Repositories\CommentRepository;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentRepository;
    public function __construct(commentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function storeComment(Request $request,$news_id)
    {
       /* if($request->type=="news"){
            if(Auth::guest()){
                $this->commentRepository->storeCommentNews($request,$news_id);
            }
            elseif(Auth::check()){
                $this->commentRepository->storeCommentNewsTwo($request,$news_id);
            }
        }
        elseif($request->type=="contractor"){
            $this->commentRepository->storeCommentContractor($request,$news_id);
        }
        if($request->type=="supplier"){
            $this->commentRepository->storeCommentSupplier($request,$news_id);
        }
        return redirect()->back();*/
    }

    public function getAllComment($news_id)
    {
      /*  $comments = $this->commentRepository->getAllComments($news_id);
        return compact('comments');*/
    }
}


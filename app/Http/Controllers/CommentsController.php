<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\Http\Requests;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(Post $postid ,Requests\CommentStoreRequest $request)
    {

        // $data = $request->all();
        // $data['post_id'] = $postid->id;

        // Comment::create($data);

        $postid->comments()->create($request->all());

        return redirect()->back()->with('comment-message','Your Comment successfully send');
    }
}

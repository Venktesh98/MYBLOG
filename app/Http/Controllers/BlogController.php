<?php

namespace App\Http\Controllers;
use App\Post;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    
    public function index()
    {
        // $post = Post::all();
        // \DB::enableQueryLog();    # for debugging the database query

        $post = Post::with('author')->latestFirst()->paginate(3);
        // $post = Post::orderBy('created_at','asc')->paginate(5);
        return view('blog.index')->with('posts_send',$post);   # remove return and add render () for DB query
        // dd("blog msg");
        // dd(\DB::getQueryLog());

    }

    // public function show($id)
    public function show(Post $postid)  # here it is called as injecting the model here
    {
        // $post = Post::findOrFail($id);
        return view('blog.show')->with("posts",$postid);
    }
}

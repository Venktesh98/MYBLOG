<?php

namespace App\Http\Controllers;
use App\Post;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $post = Post::all();
        return view('blog.index')->with('posts_send',$post);
        // dd("blog msg");
    }
}

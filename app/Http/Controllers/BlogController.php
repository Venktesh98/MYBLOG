<?php

namespace App\Http\Controllers;
use App\Post;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $author = ['name'];
    
    public function index()
    {
        // $post = Post::all();
        // \DB::enableQueryLog();
        $post = Post::with('author')->latestFirst()->paginate(3);
        // $post = Post::orderBy('created_at','asc')->paginate(5);
        return view('blog.index')->with('posts_send',$post);
        // dd("blog msg");
        // dd(\DB::getQueryLog());

    }
}

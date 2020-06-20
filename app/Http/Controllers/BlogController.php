<?php

namespace App\Http\Controllers;
use App\Post;
use App\Category;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    
    public function index()
    { 
        $categories = Category::with('posts')->orderBy('title','asc')->get();
        // $post = Post::all();
        // \DB::enableQueryLog();    # for debugging the database query

        $post = Post::with('author')->latestFirst()->paginate(3);
        return view('blog.index')->with('posts_send',$post)->with('categories',$categories);   # remove return and add render() at last in view statement for DB query
        // dd("blog msg");
        // dd(\DB::getQueryLog());
    }

    // public function show($id)
    public function show(Post $postid)  # here it is called as injecting the model here
    {
        // $post = Post::findOrFail($id);
        return view('blog.show')->with("posts",$postid);
    }
    public function category($id)
    { 
        $categories = Category::with('posts')->orderBy('title','asc')->get();
        $post = Post::with('author')->latestFirst()->where('category_id',$id)->paginate(3);
        return view('blog.index')->with('posts_send',$post)->with('categories',$categories);   # remove return and add render() at last in view statement for DB query
    }
}

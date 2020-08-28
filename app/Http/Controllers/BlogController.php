<?php

namespace App\Http\Controllers;
use App\Tag;
use App\Post;
use App\User;

use App\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $limit = 3;
    
    public function index(Request $request)
    { 
        // $post = Post::all();
        // \DB::enableQueryLog();    # for debugging the database query

        $this->limit = 3;
        $post = Post::with('author','tags','category')
                    ->latestFirst()
                    ->published()
                    ->search($request->input('term'))
                    ->paginate($this->limit);
 
        return view('blog.index')->with('posts_send',$post);   # remove return and add render() at last in view statement for DB query
        
        // dd("blog msg");
        // dd(\DB::getQueryLog());
    }

    public function category(Category $category)
    { 
        // $this->limit = 3;
        $categoryName = $category->title;
        // $posts = Category::findOrFail($id)->posts()->with('author')->latestFirst()->paginate($this->limit); 
        $posts = $category->posts()
                        ->with('author','tags')
                        ->latestFirst()
                        ->paginate($this->limit);

        return view('blog.index')->with('posts_send',$posts)->with('categoryName',$categoryName);
    } 

    // public function show($id)
    public function show(Post $postid)  # here it is called as injecting the model here and slug comes from the /Providers/RouteServiceProvider.php file
    {
        // $post = Post::findOrFail($id);
        $postid->increment('view_count');       // updating the view count whenever user refresh it.
        return view('blog.show')->with("posts",$postid);
    }   

    public function author(User $author)
    {
        // $this->limit = 3;
        $authorName = $author->name;
        $posts = $author->posts()
                    ->with('category','author')
                    ->latestFirst()
                    ->paginate($this->limit);

        return view('blog.index')->with('posts_send',$posts)->with('authorName',$authorName);
    }

   
    public function tag(Tag $tag)
    { 
        // $this->limit = 3;
        $tagName = $tag->title;
        $posts = $tag->posts()
                    ->with('author','tags')
                    ->latestFirst()
                    ->published()
                    ->paginate($this->limit);

        return view('blog.index')->with('posts_send',$posts)->with('tagName',$tagName);
    }
}

<?php

namespace App\Views\Composer;

use App\Tag;
use App\Post;
use App\Category;
use Illuminate\View\View;

class NavigationComposer
{
    public function compose(View $view)
    {
        $this->composeCategories($view);

        $this->composePopularposts($view);

        $this->composeTags($view);
    }

    private function composeCategories(View $view)
    {
        $categories = Category::with('posts')->orderBy('title','asc')->get();

        $view->with('categories',$categories);
    }

    private function composePopularposts(View $view)
    {
        $popular_posts = Post::latestFirst()->popular()->take(4)->get();
        $view->with('popularposts',$popular_posts);
    }  
    
    public function composeTags(View $view)
    {
        $tags = Tag::has('posts')->get();

        $view->with('tags',$tags);
    }
} 
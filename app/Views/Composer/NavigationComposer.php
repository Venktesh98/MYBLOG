<?php

namespace App\Views\Composer;

use Illuminate\View\View;
use App\Category;
use App\Post;

class NavigationComposer
{
    public function compose(View $view)
    {
        $this->composeCategories($view);

        $this->composePopularposts($view);
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
}
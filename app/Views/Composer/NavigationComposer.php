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

        $this->composeArchives($view);
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
    
    private function composeTags(View $view)
    {
        $tags = Tag::has('posts')->get();

        $view->with('tags',$tags);
    }

    private function composeArchives(View $view)
    {
        $archives = Post::selectRaw('count(id) as post_count,year(published_at) year,monthname(published_at) month')
                            ->published()
                            ->groupBy('year','month')
                            ->orderByRaw('min(published_at) desc')->get();
                            
        $view->with('archives',$archives);
    } 
} 
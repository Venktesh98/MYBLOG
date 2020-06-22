<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Category; 
use App\Post;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.sidebar',function($view){
            $categories = Category::with('posts')->orderBy('title','asc')->get();

            return $view->with('categories',$categories);
        });

        view()->composer('layouts.sidebar',function($view){

            $popular_posts = Post::latestFirst()->popular()->take(3)->get();
            return $view->with('popularposts',$popular_posts);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

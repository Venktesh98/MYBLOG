<?php

use App\Post;
use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();

        DB::table('categories')->insert([
            [
                'title' => 'Uncategorized',
                'slug' => 'uncategorized'
            ],
            [
                'title' => 'Tips and Tricks',
                'slug' => 'tips-and-tricks'
            ],
            [
                'title' => 'Freebies',
                'slug' => 'freebies'
            ],
            [
                'title' => 'News',
                'slug' => 'news'
            ],
            [
                'title' => 'Information Technology',
                'slug' => 'information-technology'
            ],
        ]);

        // update the posts data
        // for ($post_id = 1; $post_id <= 10; $post_id++)
        // {
        //     $category_id = rand(1, 5);

        //     DB::table('posts')
        //         ->where('id', $post_id)
        //         ->update(['category_id' => $category_id]);
        // }

        // for archives
        foreach(Post::pluck('id') as $postId)
        {
            $categories = Category::pluck('id');
            $categoryId = $categories[rand(0,$categories->count()-1)];

                DB::table('posts')
                ->where('id', $postId)
                ->update(['category_id' => $categoryId]);
        }
    }
}

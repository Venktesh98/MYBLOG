<?php

use App\Post;
use App\Comment;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $comments = [];
        $posts = Post::published()->latest()->take(5)->get();

        foreach($posts as $post)
        {
            for($i=1; $i <= rand(1,10); $i++)
            {
                $commentDate = $post->published_at->modify("+{$i} hours");
                $comments[] = [
                    'author_name' => $faker->name,
                    'author_email' => $faker->email,
                    'author_url'   => $faker->domainName,
                    'body'         =>  $faker->paragraphs(rand(1,5),true),
                    'post_id'       => $post->id,
                    'created_at'    => $commentDate,
                    'updated_at'    => $commentDate,
                ];
            }
        }
        
        DB::table('comments')->truncate();
        DB::table('comments')->insert($comments);  

        // Comment::insert($comments);

    }
}

<?php

use App\Tag;
use App\Post;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $php = new Tag();
        $php->name = "PHP";
        $php->slug = "php";
        $php->save();

        $laravel = new Tag();
        $laravel->name = "LARAVEL";
        $laravel->slug = "laravel";
        $laravel->save();

        $symphony = new Tag();
        $symphony->name = "SYMPHONY";
        $symphony->slug = "symphony";
        $symphony->save();

        $codeignitor = new Tag();
        $codeignitor->name = "CODEIGNITOR";
        $codeignitor->slug = "codeignitor";
        $codeignitor->save();

        $vue = new Tag();
        $vue->name = "VUEJS";
        $vue->slug = "vue";
        $vue->save();

        $tags = [
            $php->id,
            $laravel->id,
            $symphony->id,
            $codeignitor->id,
            $vue->id
        ];

        foreach(Post::all() as $post)
        {
            shuffle($tags);

            for($i =0; $i<rand(0,count($tags)-1); $i++)
            {
                $post->tags()->detach($tags[$i]);
                $post->tags()->attach($tags[$i]);
            }
        }
        
    }
}

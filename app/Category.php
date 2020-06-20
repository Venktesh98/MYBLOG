<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
   
    // public function getCategoryTitleAttribute($value)
    // {
    //     return $this->title;   
    // }

    public function getCategorySlugAttribute($value)
    {
        return $this->slug;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    // laravel by default finds by using id,so we are overriding id by slug here.
    public function getRouteKeyName()  
    {
        return 'slug';
    }
}

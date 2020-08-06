<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    protected $fillable = ['title','slug'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    // public function getCategoryTitleAttribute($value)
    // {
    //     return $this->title;   
    // }

    // public function getCategorySlugAttribute($value)
    // {
    //     return $this->slug;
    // }
    
    // public function scopecategoryOrder($query)
    // {
    //     return $query->orderBy('title');
    // }

    public function getRouteKeyName()   # called as binding with url i.e comes from app/Providers/RouteServiceProvider.php
    {
        return 'slug';
    }
}

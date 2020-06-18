<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; 

class Post extends Model
{
    protected $dates = ['published_at'];

    public function author()
    {
        return $this->belongsTo(User::class);
    }
    
    // Defining the Accesssor for image attribute over here that is called when model is called 
    public function getImageUrlAttribute($value)
    {
        $imageUrl = "";

        if(! is_null($this->image)) # image is the attribute in the database.
        {
            $imagePath = public_path() . "/img/" . $this->image;
            if(file_exists($imagePath)) 
            {
                $imageUrl = asset("img/" . $this->image); # gets the relevant path of the image if the image exists.

            }
        }
        return $imageUrl;
    }

    public function getDateAttribute($value)
    {
        return is_null($this->published_at) ? '' : $this->published_at->diffForHumans();     # will creats the date for human readble form.
    }
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('published_at','desc');
    }

    // public function scopePublished($query)
    // {
    //     return $query->where("published_at","<=",Carbon::now());   # not working coz of php version might be
    // } 
}

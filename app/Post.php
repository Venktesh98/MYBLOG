<?php

namespace App;

use GrahamCampbell\Markdown\Facades\Markdown;   # for Markdown i.e for html presentation of contents on the blog
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;                              # for date and time had use the carbon api.

class Post extends Model
{
    protected $dates = ['published_at'];

    public function author()
    {
        return $this->belongsTo(User::class);
    }
    
    // Defining the Accesssor function for image attribute over here that is called when model is called 
    public function getImageUrlAttribute($value)
    {
        $imageUrl = "";

        if(! is_null($this->image)) # image is the attribute in the database.
        {
            $imagePath = public_path() . "/img/" . $this->image;  # public_path() is the helper function to get the path of the public directory
            if(file_exists($imagePath)) 
            {
                $imageUrl = asset("img/" . $this->image); # gets the relevant path of the image if the image exists using asset().

            }
        }
        return $imageUrl;
    }

    // Accessor Function
    public function getDateAttribute($value)
    {
        // return is_null($this->published_at) ? '' : $this->published_at->diffForHumans();     # will creats the date for human readble form.
        return is_null($this->created_at) ? '' : $this->created_at->diffForHumans();
    }

    // Accessor Function
    public function getBodyHtmlAttribute($value)
    {
         return $this->body ? Markdown::convertToHtml(e($this->body)) : NULL;  # e is laravel helper function that is used for security purpose.
    }

    // Accessor Function
    public function getExcerptHtmlAttribute($value)
    {
         return $this->excerpt ? Markdown::convertToHtml(e($this->excerpt)) : NULL;  # e is laravel helper function that is used for security purpose.
    }

    // Scope
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('published_at','desc');
    }

    // public function scopePublished($query)
    // {
    //     return $query->where("published_at","<=",Carbon::now());   # not working coz of php version might be
    // } 
}

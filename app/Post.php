<?php

namespace App;

use GrahamCampbell\Markdown\Facades\Markdown;   # for Markdown i.e for html presentation of contents on the blog
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;                              # for date and time had use the carbon api.

class Post extends Model
{
    protected $fillable = ['title','slug','excerpt','body','published_at','category_id','image'];

    protected $dates = ['published_at'];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // mutator invoked when the published_at is Null 
    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = $value ? : NULL;
    }

    // It shows the date according to the format
    public function dateFormatted($showTimes = false)
    {
        $format = "d/m/Y";
        if($showTimes)
        {
            $format = $format . "H:i:s";
        }
        return $this->created_at->format($format);
    }

    // This method displays the date according to the published date
    public function publicationLabel()
    {
        if($this->published_at == NULL)
        {
            return '<span class = "label label-warning">Draft</span>';
        }

        elseif($this->published_at && $this->published_at->isFuture())
        {
            return '<span class = "label label-info">Schedule</span>';
        }
        
        else
        {
            return '<span class = "label label-success">Published</span>';
        }
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
   
    // Accessor function for the thumbnails
    public function getImageThumbUrlAttribute($value)
    {
        $imageUrl = "";

        if(! is_null($this->image)) # image is the attribute in the database.
        {   
            $ext = substr(strrchr($this->image,'.') ,1);
            $thumbnail = str_replace(".{$ext}","_thumb.{$ext}",$this->image);   
            $imagePath = public_path() . "/img/" . $thumbnail;  # public_path() is the helper function to get the path of the public directory
            if(file_exists($imagePath)) 
            {
                $imageUrl = asset("img/" . $thumbnail); # gets the relevant path of the image if the image exists using asset().
        
            }
        }
        return $imageUrl;
    }

    // Accessor Function for date attribute
    public function getDateAttribute($value)
    {
        // return is_null($this->published_at) ? '' : $this->published_at->diffForHumans();     # will creats the date for human readble form.
        return is_null($this->created_at) ? '' : $this->created_at->diffForHumans();
    }

    // Accessor Function for getting the html attribute for body
    public function getBodyHtmlAttribute($value)
    {
         return $this->body ? Markdown::convertToHtml(e($this->body)) : NULL;  # e is laravel helper function that is used for security purpose.
    }

    // Accessor Function for getting the html attribute for excerpt
    public function getExcerptHtmlAttribute($value)
    {
         return $this->excerpt ? Markdown::convertToHtml(e($this->excerpt)) : NULL;  # e is laravel helper function that is used for security purpose.
    }
    
    // Scope for fetching the latest post
    public function scopeLatestFirst($query)    # This will be used in the Blogcontroller.php 
    {
        return $query->orderBy('published_at','desc');
    }

    public function scopePopular($query)    # This will invokes the View/Composer/NavigationComposer.php
    {
        return $query->orderBy('view_count','desc');
    }

    // public function scopePublished($query)
    // {
    //     return $query->where("published_at","<=",Carbon::now());   # not working coz of php version might be
    // } 

}

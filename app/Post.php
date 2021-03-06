<?php

namespace App;

use App\Comment;
use Illuminate\Database\Eloquent\Model;
// use Cviebrock\EloquentTaggable\Taggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;                              # for date and time had use the carbon api.
use GrahamCampbell\Markdown\Facades\Markdown;   # for Markdown i.e for html presentation of contents on the blog

class Post extends Model
{
    // use Taggable;
    
    use SoftDeletes;   // This is used to moving the deleted post to the trash called as trait.

    protected $fillable = ['title','slug','excerpt','body','published_at','category_id','image'];   // for not occuring the mass assignment error

    protected $dates = ['published_at'];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags() 
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentsNumber($label = 'Comment')
    {
        $commentsNumber = $this->comments->count();

        return $commentsNumber . " " . str_plural($label,$commentsNumber);
    }

    public function createTags($tagString)
    {
        $tags = explode(",",$tagString);          // converts the string into array
        $tagIds = [];

        foreach ($tags as $tag) 
        {    
        
            // $newTag = new Tag();
            // $newTag->name = ucwords(trim($tag));
            // $newTag->slug = str_slug($tag);
            // $newTag->save(); 
            
            // firstOrCreate() is used to find that the data exists in the database or not
            $newTag = Tag::firstOrCreate(
                ['slug' => str_slug($tag),'name' => ucwords(trim($tag))]
            );

            $tagIds[] = $newTag->id;
        }

        // $this->tags()->attach($tagIds);
        $this->tags()->sync($tagIds);
    }

    // mutator invoked when the published_at contains Null value
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
        return is_null($this->published_at) ? '' : $this->published_at->diffForHumans();     # will creats the date for human readble form.
        // return is_null($this->created_at) ? '' : $this->created_at->diffForHumans();
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

    public function getTagsListAttribute()
    {
        return $this->tags->pluck('name');
    }

    // public function getTagsHtmlAttribute($value)
    // {
    //     @foreach ($post->tags as $tag) 
    //         <a href="/tags/{{ $tag->slug }}">{{ $tag->name }}</a>,
    //     @endforeach  
    // }
    
    // Scope for fetching the latest post
    public function scopeLatestFirst($query)    # This will be used in the Blogcontroller.php 
    {
        return $query->orderBy('published_at','desc');
    }

    public function scopePopular($query)    # This will invokes the View/Composer/NavigationComposer.php
    {
        return $query->orderBy('view_count','desc');
    }

    public function scopePublished($query)
    {
        return $query->where("published_at","<=",Carbon::now());   # not working coz of php version might be
    } 

    public function scopeScheduled($query)
    {
        return $query->where("published_at",">",Carbon::now());   
    } 

    public function scopeDraft($query)
    {
        return $query->whereNull("published_at");   
    } 

    public function scopeSearch($query,$search)
    {
        if(isset($search['month']))
        {
            $querymonth = $search['month'];
            // $query->whereMonth('published_at',[Carbon::parse($querymonth)->month]);     // Carbon::parse($querymonth) used to convert month into month number 
            $query->whereMonth('published_at',[$querymonth]);      // for postgres sql
        }
 
        if(isset($search['year'])) 
        {
            $queryyear = $search['year'];
            $query->whereYear('published_at',[$queryyear]);
        }

        // check if any term entered
        if(isset($search['term']))
        { 
            $queryterm = $search['term'];

            // this function is used for binding the below queries in paranthesis ().
            $query->where(function($q) use ($queryterm)   
            {
                // $q->whereHas('author',function($qr) use ($term){
                //     $qr->orWhere('name','LIKE',"%{$term}%");
                // });

                // $q->whereHas('category',function($qr) use ($term){
                //     $qr->orWhere('title','LIKE',"%{$term}%");
                // });

                $q->Where('title','LIKE',"%{$queryterm}%");
                $q->orWhere('excerpt','LIKE',"%{$queryterm}%");
            });
        }  
    } 
    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }
}

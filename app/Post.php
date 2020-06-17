<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
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
}

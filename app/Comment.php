<?php

namespace App;

use App\Post;
use Illuminate\Database\Eloquent\Model;
use GrahamCampbell\Markdown\Facades\Markdown;
 
class Comment extends Model
{
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getDateAttribute($value)
    {
        return is_null($this->created_at) ? '' : $this->created_at->diffForHumans();
    }

    public function getBodyHtmlAttribute($value)
    {
        return $this->body ? Markdown::convertToHtml(e($this->body)) : NULL;  # e is laravel helper function that is used for security purpose.
    }
}

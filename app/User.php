<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{   
    use LaratrustUserTrait;    # this trait is used to create the relationship with Role and Permission models
    
    protected $table = users;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class , 'author_id');
    }

    public function gravatar()   # it is used for inserting the image of user based on his email
    {
        $email = $this->email;
        $default = "https://icons-for-free.com/iconfiles/png/512/business+costume+male+man+office+user+icon-1320196264882354682.png";
        $size = 20;

        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
    }

    // Accessor Function
    // public function getGravatarImageAttribute($value)
    // {
    //     $email = $this->email;
    //     $default = "https://icons-for-free.com/iconfiles/png/512/business+costume+male+man+office+user+icon-1320196264882354682.png";
    //     $size = 20;

    //     return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
    // }

    // function injecting.
    public function getRouteKeyName()  
    {
        return 'slug';
    }

    public function getBioHtmlAttribute($value)
    {
        return $this->bio ? Markdown::convertToHtml(e($this->bio)) : NULL;  # e is laravel helper function that is used for security purpose.
    }

    // Mutator for setting the hash passsword.
    public function setPasswordAttribute($value)
    {
        if(!empty($value)) 
        {
            $this->attributes['password'] = bcrypt($value);
        }
    }
}

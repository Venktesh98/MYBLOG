<?php

namespace App\Http\Controllers\Backend;

use config;
use App\Tag;
use App\Post;
use App\Http\Requests;
use Illuminate\Http\Request;
use UxWeb\SweetAlert\SweetAlert;
use Intervention\Image\Facades\Image;

class BlogController extends BackendController
{
    protected $uploadPath;

    public function __construct()
    {
        parent::__construct();   # for adding the middleware

        // $this->uploadPath =  public_path('img');    # gets the path of the img directory of the public folder
        $this->uploadPath =  public_path(config('cms.image.directory'));
    }

    public function index(Request $request)
    {
        $onlyTrashed = FALSE;          # by default posts are null

        // only shows the items that are in the trash using onlyTrashed()
        if(($status = $request->input('status')) && $status == 'trash')
        {
            $posts = Post::onlyTrashed()->with('author','category')->latest()->simplePaginate($this->limit);
            $postCount = Post::onlyTrashed()->count(); 
            $onlyTrashed = TRUE;  # flag for showing the trash posts 
        }

        elseif($status == 'published')
        {
            $posts = Post::published()->with('author','category')->latest()->simplePaginate($this->limit);
            $postCount = Post::published()->count();   # counts all the published posts  
        }

        elseif($status == 'scheduled')
        {
            $posts = Post::scheduled()->with('author','category')->latest()->simplePaginate($this->limit);
            $postCount = Post::scheduled()->count();   # counts all the scheduled posts  
        }

        elseif($status == 'draft')
        {
            $posts = Post::draft()->with('author','category')->latest()->simplePaginate($this->limit);
            $postCount = Post::draft()->count();   # counts all the draft posts  
        }

        elseif($status == 'own')
        {
            $posts = $request->user()->posts()->with('author','category')->latest()->simplePaginate($this->limit);
            $postCount = $request->user()->posts()->count();   # counts all the draft posts  
        }
 
        else
        {
            $posts = Post::with('author','category')->latest()->simplePaginate($this->limit);
            $postCount = Post::count();   # counts all the posts  
        }
        
        $statusList = $this->statusList($request);
        // $postCount = $this->limit; # counts only the posts that are on the page.

        return view('backend.blog.index',compact('posts','postCount','onlyTrashed','statusList'));
    }

    // returns the number of posts according to the publication below
    private function statusList($request)
    {
        return [
            'own' => $request->user()->posts()->count(),
            'all' => Post::count(),
            'published' => Post::published()->count(),
            'scheduled' => Post::scheduled()->count(),
            'draft' => Post::draft()->count(),
            'trash' => Post::onlyTrashed()->count(),
        ];
    }

    public function create(Post $posts)
    {
       
        return view('backend.blog.create',compact('posts'));
    }

    public function store(Requests\PostRequest $request)
    {
        $data = $this->handleRequest($request);        // Contains the image uploading stuff.

        // here user() is to get the current user who makes the request.
        $newPost = $request->user()->posts()->create($data);   # can also be used $request->only('title') or any any attribute to get.
        $newPost->createTags($data["post_tags"]);
        
        alert()->success('From MYBLOG','Your Post has been Created Successfully!')->autoclose(3500);
        return redirect('/backend/blog');
    }

    // used for handling the request for image uploading
    public function handleRequest($request)
    {
        $data = $request->all();

        if($request->hasFile('image'))
        {
            // gets the image from html form
            $image = $request->file('image');

            // gets the image fileName
            $fileName = $image->getClientOriginalName();

            // destination of the image i.e the img directory of public folder
            $destination = $this->uploadPath;

            // moves the image to the sepecified destination
            $succesfullyUpload = $image->move($destination,$fileName);

            if($succesfullyUpload)
            {
                // gets the width and height of the image from the config/cms.php
                $width = config('cms.image.thumbnail.width');
                $height = config('cms.image.thumbnail.height');

                // gets the file extension
                $extension = $image->getClientOriginalExtension();

                // replaces extension with _thumb.extension of original filename.
                $thumbnail = str_replace(".{$extension}","_thumb.{$extension}",$fileName);

                // saves the image thumbnail in img directory
                Image::make($destination.'/'.$fileName)
                                    // ->resize(250,170)
                                    ->resize($width,$height)
                                    ->save($destination.'/'.$thumbnail);
            }

            // stores the image name in the database
            $data['image'] = $fileName;
        }

        return $data;
    }


    public function show($id)     
    {
        //
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('backend.blog.edit',compact('post'));
    }

    public function update(Requests\PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $oldImage  = $post->image;
        $data = $this->handleRequest($request);
        $post->update($data);                                   # updates in the DB.
        $post->createTags($data['post_tags']);

        if($oldImage!= $post->image)
        {
            $this->removeImage($oldImage);                      # removes the old Image from the server
        }

        alert()->success('From MYBLOG','Your Post has been Updated Successfully!')->autoclose(3500);
        return redirect('/backend/blog');
        
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect('/backend/blog')->with('trash-message',['Your Post moved to Trash',$id]);
        // alert()->error('From MYBLOG','Your Post has been Moved to Trash!')->autoclose(3500);
        // return redirect('/backend/blog');    
    }

    public function restore($id)    
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();

        alert()->success('From MYBLOG','Your Post has been restored from Trash!')->autoclose(3500);
        return redirect()->back();

        // return redirect()->back()->with('message','Your Post has been restored from Trash!');
    }

    // will forcefully deletes the post.
    public function forceDestroy($id)
    {
        $post = Post::onlyTrashed()->findOrfail($id); 
        $post->forceDelete();

        $this->removeImage($post->image);                   # removes the image from the database
    
        alert()->info('From MYBLOG','Your Post has been Deleted Successfully!')->autoclose(3500);
        return redirect('backend/blog?status=trash');
    }

    // used for removing the image permanently from the server.
    private function removeImage($image)
    {
        if(!empty($image))
        {
            $imagePath = $this->uploadPath .'/'. $image;                    # gets the image
            $ext = substr(strchr($image,'.'),1);                            # gets the extension of the image
            $thumbnail = str_replace(".{$ext}","_thumb.{$ext}",$image);     # gets the thumbnail
            $thumbnailPath = $this->uploadPath .'/'. $thumbnail;            # gets the thumbnail image.
            
            if(file_exists($imagePath))
            {
                unlink($imagePath);     # removes the image from the /public/img/ directory
            }

            if(file_exists($thumbnailPath))
            {
                unlink($thumbnailPath);     # removes the image from the /public/img/ directory
            }
        }
    }
}

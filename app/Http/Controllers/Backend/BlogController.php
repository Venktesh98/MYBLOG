<?php

namespace App\Http\Controllers\Backend;

use App\Post;
use App\Http\Requests;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
// use App\Http\Requests\PostRequest;
// use App\Http\Controllers\Controller;

class BlogController extends BackendController
{
    protected $limit = 5;
    protected $uploadPath;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        parent::__construct();   # for adding the middleware

        // $this->uploadPath =  public_path('img');    # gets the path of the img directory of the public folder
        $this->uploadPath =  public_path(config('cms.image.directory'));
    }

    public function index(Request $request)
    {
        // only shows the items that are in the trash using onlyTrashed()
        if(($status = $request->input('status')) && $status == 'trash')
        {
            $posts = Post::onlyTrashed()->with('author','category')->latest()->paginate($this->limit);
            $postCount = Post::onlyTrashed()->count(); 
            $onlyTrashed = TRUE;  # flag for showing the trash items 
        }
        else
        {
            $posts = Post::with('author','category')->latest()->paginate($this->limit);
            $postCount = Post::count();   # counts all the items 
            $onlyTrashed = FALSE;
        }
        
        // $postCount = $this->limit; # counts only the items that are on the page.
        return view('backend.blog.index',compact('posts','postCount','onlyTrashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Post $posts)
    {

        return view('backend.blog.create',compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\PostRequest $request)
    {
        $data = $this->handleRequest($request);

        // here user() is to get the current user who makes the request.
        $request->user()->posts()->create($data);   # can also be used $request->only('title') or any any attribute to get.

        # Can also be done by this way
        // $post = new Post;
        // $post->title = request('title');
        // $post->slug = request('slug');
        // $post->excerpt = request('excerpt');
        // $post->body = request('body');
        // $post->published_at = request('published_at');
        // $post->category_id = request('category_id');
        // $post->author_id = auth()->user()->id;

        // $post->save();
        return redirect('/backend/blog')->with('message','Your Post has been Created Successfully!');
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('backend.blog.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $data = $this->handleRequest($request);
        $post->update($data);    # updates in the DB.

        return redirect('/backend/blog')->with('message','Your Post was Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect('/backend/blog')->with('trash-message',['Your Post moved to Trash',$id]);
        // dd($post);
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();

        return redirect('/backend/blog')->with('message','Your Post has been removed from Trash!');
    }

    // will forcefully deletes the post.
    public function forceDestroy($id)
    {
        $post = Post::onlyTrashed()->findOrfail($id)->forceDelete();

        return redirect('backend/blog?status=trash')->with('message','Your Post has been Deleted Successfully!');
    }
}

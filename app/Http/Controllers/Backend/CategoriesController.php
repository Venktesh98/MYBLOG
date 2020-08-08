<?php

namespace App\Http\Controllers\Backend;

use App\Post;
use App\Category;
use App\Http\Requests;
use Illuminate\Http\Request;

class CategoriesController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $categories = Category::with('posts')->latest()->paginate($this->limit);
       $categoriesCount = Category::count();

       return view('backend.categories.index',compact('categories','categoriesCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category)
    {
        return view('backend.categories.create',compact('category'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CategoryStoreRequest $request)
    {
        # First Method
        // $category = new Category;
        // $category->title = $request->input('title');
        // $category->slug = $request->input('slug');
        // $category->save();

        # Second one
        Category::create($request->all());
        return redirect('/backend/categories')->with('message','New Category Created Successfully!');
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
        $category = Category::findOrFail($id);
        
        return view('backend.categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CategoryUpdateRequest $request, $id)
    {
        # First Method

        // $category = Category::findOrFail($id);

        // $category->title = $request->input('title');
        // $category->slug = $request->input('slug');
        // // $category->update();
        // $category->save();

        #second Method
        Category::findOrFail($id)->update($request->all()); 

        return redirect('/backend/categories')->with('message','Your Category Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requests\CategoryDestroyRequest $request, $id)
    {
        Post::withTrashed()->where('category_id',$id)->update(['category_id' => config('cms.default_category_id')]);
        $category = Category::findOrFail($id);
        $category->delete(); 

        return redirect('/backend/categories')->with('message','Your Category deleted Successfully!');
    }
}

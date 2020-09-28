<?php

namespace App\Http\Controllers\Backend;

use App\Post;
use App\Category;
use App\Http\Requests;
use Illuminate\Http\Request;

class CategoriesController extends BackendController
{
   
    public function index()
    {
       $categories = Category::with('posts')->latest()->simplePaginate($this->limit);
       $categoriesCount = Category::count();

       return view('backend.categories.index',compact('categories','categoriesCount'));
    }

    public function create(Category $category)
    {
        return view('backend.categories.create',compact('category'));  
    }

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

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        
        return view('backend.categories.edit',compact('category'));
    }

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

    public function destroy(Requests\CategoryDestroyRequest $request, $id)
    {
        Post::withTrashed()->where('category_id',$id)->update(['category_id' => config('cms.default_category_id')]);
        $category = Category::findOrFail($id);
        $category->delete(); 

        return redirect('/backend/categories')->with('message','Your Category deleted Successfully!');
    }
}

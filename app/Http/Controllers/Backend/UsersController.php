<?php

namespace App\Http\Controllers\Backend;

use App\User;
use App\Post;
use App\Http\Requests;
use Illuminate\Http\Request;

class UsersController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $users = User::orderBy('name')->paginate($this->limit);
       $usersCount = User::count();

       return view('backend.users.index',compact('users','usersCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        return view('backend.users.create',compact('user'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\UserStoreRequest $request)
    {

        User::create($request->all());
        return redirect('/backend/users')->with('message','New User Created Successfully!');
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
        $user = User::findOrFail($id);
        
        return view('backend.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UserUpdateRequest $request, $id)
    {
       
        User::findOrFail($id)->update($request->all()); 

        return redirect('/backend/users')->with('message','Your User Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requests\UserDestroyRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $deleteOption = $request->input('delete_option');
        $selectedUser = $request->input('selected_user');

        if($deleteOption == 'delete'){
            // deletes all user posts from index page and also from trash.
            $user->posts()->withTrashed()->forceDelete();            
        }

        // Assigns the deleting user all posts to selected user
        if($deleteOption == 'attribute'){
            $user->posts()->update(['author_id' => $selectedUser]);
        }
        
        $user->delete(); 

        return redirect('/backend/users')->with('message','Your User deleted Successfully!');
    }

    public function confirm(Requests\UserDestroyRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $users = User::where('id','!=',$user->id)->pluck('name','id');
        return view("backend.users.confirm",compact('user','users'));
    }
}

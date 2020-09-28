<?php

namespace App\Http\Controllers\Backend;

use App\User;
use App\Post;
use App\Http\Requests;
use Illuminate\Http\Request;

class UsersController extends BackendController
{
    public function index()
    {
       $users = User::orderBy('name')->paginate($this->limit);
       $usersCount = User::count();

       return view('backend.users.index',compact('users','usersCount'));
    }

    public function create(User $user)
    {
        return view('backend.users.create',compact('user'));  
    }

    public function store(Requests\UserStoreRequest $request)
    {

        $user = User::create($request->all());
        $user->attachRole($request->role);
        return redirect('/backend/users')->with('message','New User Created Successfully!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        return view('backend.users.edit',compact('user'));
    }

    public function update(Requests\UserUpdateRequest $request, $id)
    {
       
        $user = User::findOrFail($id);
        $user->update($request->all());
        
        $user->detachRoles();
        $user->attachRole($request->role);

        return redirect('/backend/users')->with('message','Your User Updated Successfully!');
    }

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

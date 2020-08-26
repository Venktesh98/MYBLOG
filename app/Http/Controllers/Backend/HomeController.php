<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends BackendController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        return view('backend.home.index');
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        return view('backend.home.edit',compact('user'));
    }

    public function update(Requests\UserProfileUpdateRequest $request)
    {
        $user = $request->user();

        $user->update($request->all());

        return redirect()->back()->with('message','Profile updated successfully!');
    }
}


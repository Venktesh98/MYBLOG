@extends('layouts.backend.main')

<title> MyBlog | Delete confirmation </title>
@section('content')
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Users
          <small> <strong> Delete Confirmation </strong> </small>
        </h1>
        <ol class="breadcrumb">
          <li>
              <a href="/home"><i class="fa fa-dashboard"></i> Dashboard</a>
          </li>

          <li>
              <a href="{{route('users.index')}}">users</a>
          </li>
          <li class="active">Delete confirmation</li>
        </ol>
      </section>
      
      <!-- Main content -->
      <section class="content">
          <div class="row">
                {!! Form::model($user,[
                  'method'=>'DELETE',
                  'route'=>['users.destroy',$user->id], 
              ]) !!}

              <div class="col-xs-9">
                  <div class="box">
                      <div class="box-body">
                          <p>
                            <i>You have specified this user for the Deletion</i> 
                          </p>

                          <p>
                            ID #<strong>{{$user->id}}</strong>:<strong>{{$user->name}}</strong>
                          </p>

                          <p>
                            What should be done with content of the user?
                          </p>

                          <p>
                            <input type="radio" name="delete_option" value="delete" checked>&nbsp;&nbsp;Delete All Content
                          </p>

                          <p>
                            <input type="radio" name="delete_option" value="attribute">&nbsp;&nbsp;Assign Attribute Content to:
                            {!! Form::select('selected_user',$users,null) !!}
                          </p>
                      </div>

                      <div class="box-footer">
                          <button type="submit" class="btn btn-danger">Confirm Delete</button>
                          <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</a>
                      </div>
                  </div>
              </div>
            {!! Form::close() !!}               <!-- form close -->
          </div>
        <!-- ./row -->
      </section>
      <!-- /.content -->
  </div>  
@endsection



@extends('layouts.backend.main')

<title> MyBlog | Add New user </title>
@section('content')
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Users
          <small> <strong> Add New User </strong> </small>
        </h1>
        <ol class="breadcrumb">
          <li>
              <a href="/home"><i class="fa fa-dashboard"></i> Dashboard</a>
          </li>

          <li>
              <a href="{{route('users.index')}}">users</a>
          </li>
          <li class="active">Add New</li>
        </ol>
      </section>
      
      <!-- Main content -->
      <section class="content">
          <div class="row">
                {!! Form::model($user,[
                  'method'=>'POST',
                  'route'=>'users.store',
                  'files'=>TRUE,                  # This is for multipart for uploading the image
                  'id'=>'user-form'           # gets fired when javascript Event handler is invoked
              ]) !!}

            @include('backend.users.form')       <!-- includes the Whole Form here -->

            {!! Form::close() !!}               <!-- form close -->
          </div>
        <!-- ./row -->
      </section>
      <!-- /.content -->
  </div>  
@endsection



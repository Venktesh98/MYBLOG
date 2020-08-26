@extends('layouts.backend.main')

<title> MyBlog | Edit Profile </title>
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile
        <small> <strong> Edit Profile </strong> </small>
      </h1>
      <ol class="breadcrumb">
        <li>
            <a href="/home"><i class="fa fa-dashboard"></i> Dashboard</a>
        </li>

        <li>
            <a href="{{route('users.index')}}">profile</a>
        </li>
        <li class="active">Edit profile</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="row">
          @include('backend.messages.message')
              {!! Form::model($user,[
                'method'=>'PUT',
                'url'=>'/edit-profile',
                'id'=>'user-form'                       # gets fired when javascript Event handler is invoked
            ]) !!}

          @include('backend.home.form',['hideRoleDropdown' => true])       <!-- includes the Whole Form here -->

          {!! Form::close() !!}                     <!-- form close -->
        </div>
      <!-- ./row -->
    </section>
</div>
    <!-- /.content -->  
@endsection



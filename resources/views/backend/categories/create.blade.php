@extends('layouts.backend.main')

<title> MyBlog | Add New Post </title>
@section('content')
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Categories
          <small> <strong> Add New Category </strong> </small>
        </h1>
        <ol class="breadcrumb">
          <li>
              <a href="/home"><i class="fa fa-dashboard"></i> Dashboard</a>
          </li>

          <li>
              <a href="{{route('categories.index')}}">Categories</a>
          </li>
          <li class="active">Add New</li>
        </ol>
      </section>
      
      <!-- Main content -->
      <section class="content">
          <div class="row">
                {!! Form::model($category,[
                  'method'=>'POST',
                  'route'=>'categories.store',
                  'files'=>TRUE,                  # This is for multipart for uploading the image
                  'id'=>'category-form'           # gets fired when javascript Event handler is invoked
              ]) !!}

            @include('backend.categories.form')       <!-- includes the Whole Form here -->

            {!! Form::close() !!}               <!-- form close -->
          </div>
        <!-- ./row -->
      </section>
      <!-- /.content -->
  </div>  
@endsection

@include('backend.categories.script')         <!-- includes the all javascript code -->


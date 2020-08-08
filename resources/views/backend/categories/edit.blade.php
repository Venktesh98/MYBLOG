@extends('layouts.backend.main')

<title> MyBlog | Edit category </title>
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Categories
        <small> <strong> Edit Category </strong> </small>
      </h1>
      <ol class="breadcrumb">
        <li>
            <a href="/home"><i class="fa fa-dashboard"></i> Dashboard</a>
        </li>

        <li>
            <a href="{{route('categories.index')}}">Category</a>
        </li>
        <li class="active">Edit Category</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="row">
              {!! Form::model($category,[
                'method'=>'PUT',
                'route'=>['categories.update',$category->id],
                'files'=>TRUE,                          # This is for multipart for uploading the image
                'id'=>'category-form'                   # gets fired when javascript Event handler is invoked
            ]) !!}

          @include('backend.categories.form')       <!-- includes the Whole Form here -->

          {!! Form::close() !!}                     <!-- form close -->
        </div>
      <!-- ./row -->
    </section>
</div>
    <!-- /.content -->  
@endsection

@include('backend.categories.script')         <!-- includes the all javascript code -->


@extends('layouts.backend.main')

<title> MyBlog | Add New Post </title>
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Blogs
        <small> <strong> Add new post </strong> </small>
      </h1>
      <ol class="breadcrumb">
        <li>
            <a href="/home"><i class="fa fa-dashboard"></i> Dashboard</a>
        </li>

        <li>
            <a href="{{route('blog.index')}}">Blog</a>
        </li>
        <li class="active">All Posts</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <!-- /.box-header -->
              <div class="box-body">
                   {!! Form::model($post,[
                       'method'=>'POST',
                       'route'=>'blog.store',
                       'files'=>TRUE              # This is for multipart for uploading the image
                   ]) !!}

                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}" >
                        {!! Form::label('title') !!}
                        {!! Form::text('title',null,['class'=>'form-control']) !!}

                        @if ($errors->has('title'))
                            <span class='help-block'>{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                        {!! Form::label('slug') !!}
                        {!! Form::text('slug',null,['class'=>'form-control']) !!}

                        @if ($errors->has('slug'))
                            <span class='help-block'>{{ $errors->first('slug') }}</span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('excerpt') ? 'has-error' : '' }}">
                        {!! Form::label('excerpt') !!}
                        {!! Form::textarea('excerpt',null,['class'=>'form-control']) !!}

                        @if ($errors->has('excerpt'))
                            <span class='help-block'>{{ $errors->first('excerpt') }}</span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                        {!! Form::label('body') !!}
                        {!! Form::textarea('body',null,['class'=>'form-control']) !!}

                        @if ($errors->has('body'))
                            <span class='help-block'>{{ $errors->first('body') }}</span>
                        @endif

                    </div>

                    <div class="form-group {{ $errors->has('published_at') ? 'has-error' : '' }}">
                        {!! Form::label('published_at',"Published Date") !!}
                        {!! Form::text('published_at',null,['class'=>'form-control','placeholder'=>'Y-m-d H:i:s']) !!}

                        @if ($errors->has('published_at'))
                            <span class='help-block'>{{ $errors->first('published_at') }}</span>
                        @endif

                    </div>

                    <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                        {!! Form::label('category_id','Category') !!}
                        {!! Form::select('category_id',App\Category::pluck('title','id'),null,['class'=>'form-control','placeholder'=>'Choose Category']) !!}

                        @if($errors->has('category_id'))
                            <span class='help-block'>{{ $errors->first('category_id') }}</span>
                        @endif

                    </div>

                    <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                      {!! Form::label('image','Feature Image') !!}
                      {!! Form::file('image') !!}

                      @if($errors->has('image'))
                          <span class='help-block'>{{ $errors->first('image') }}</span>
                      @endif

                  </div>

                    {!! Form::submit('Create New Post',['class'=>'btn btn-primary'])!!}

                   {!! Form::close() !!}
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        </div>
      <!-- ./row -->
    </section>
    <!-- /.content -->
  </div>
@endsection

@section('script')
    <script type = text/javascript>
        $('ul.pagination').addClass('no-margin pagination-sm');
    </script>
@endsection


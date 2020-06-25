@extends('layouts.backend.main')

<title> MyBlog | BLOG index </title>
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Blogs
        <small> <strong> Display all blog posts </strong> </small>
      </h1>
      <ol class="breadcrumb">
        <li>
            <a href="/home"><i class="fa fa-dashboard"></i> Dashboard</a>
        </li>

        <li>
            <a href="{{route('blog.index')}}">Blog</a>
        </li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="pull-left">
                       <a href="{{ route('blog.create') }}" class = "btn btn-success" >Add New</a>
                    </div>
                </div>
        
              <!-- /.box-header -->
              <div class="box-body ">

                    @if ($posts == NULL)
                        <div class="alert alert-danger">
                            <strong>No Record Found </strong>
                        </div>
    
                    @else
                    
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td width="80">Action</td>
                                    <td>Title</td>
                                    <td width = "100">Author</td>
                                    <td width = "160">Category</td>
                                    <td width = "160">Date</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>
                                            <a href="{{ route('blog.edit',$post->id) }}" class="btn btn-xs btn-primary">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a href="route('blog.destroy',$post->id)" class="btn btn-xs btn-danger">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                        <td>{{$post->title}}</td>
                                        <td>{{$post->author->name}}</td>
                                        <td>{{$post->category->title}}</td>
                                        <td>
                                            <abbr title="$post->dateFormatted(true)">{{$post->dateFormatted()}}</abbr> |
                                            {!! $post->publicationLabel() !!}   <!-- Shows the date from the Post model -->
                                        </td> 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
              </div>
              <!-- /.box-body -->
              <div class="box-footer clearfix">
                  <div class="pull-left">
                        {{-- <ul class="pagination no-margin">
                            <li><a href = "#">&laquo;</a></li>
                            <li><a href = "#">1</a></li>
                            <li><a href = "#">2</a></li>
                            <li><a href = "#">3</a></li>
                            <li><a href = "#">&raquo;</a></li>
                        </ul> --}}
                        {{ $posts->render() }}                                  <!-- for pagination -->
                    </div>
                    
                    <div class="pull-right">                                    <!-- displays the total number of post -->
                        <small>{{ $postCount }} {{ str_plural('Item',$postCount) }}</small>
                    </div>
              </div>
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


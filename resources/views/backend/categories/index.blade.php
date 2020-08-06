@extends('layouts.backend.main')

<title> MyBlog | BLOG Category index </title>
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

       {{-- @include('backend.blog.statusLabel')        <!-- includes the Labels of the Blog Post according to the publicaton --> --}}
       <h1>
            Categories
            <small> <strong>Display All Categories </strong> </small>
        </h1>

      <ol class="breadcrumb">
        <li>
            <a href="/home"><i class="fa fa-dashboard"></i> Dashboard</a>
        </li>

        <li>
            <a href="{{route('categories.index')}}">Categories</a>
        </li>

        <li class="active">All Categories</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="pull-left">
                       <a href="{{ route('categories.create') }}" class = "btn btn-success" ><i class="fa fa-plus"></i> Add New</a>
                    </div>

                    <div class="pull-right" style="padding: 7px 0;">
                    </div>

                </div>
        
              <!-- /.box-header -->
              <div class="box-body ">
                   @include('backend.messages.message')

                    @if ( !$categories->count())
                        <div class="alert alert-danger">
                            <strong>No Record Found </strong>
                        </div>
                    @else
                        @include('backend.categories.table-allposts')
                    @endif
              </div>
              <!-- /.box-body -->
              <div class="box-footer clearfix">
                  <div class="pull-left">
                        {{ $categories->appends(request()->query())->links() }}               <!-- for pagination -->
                    </div>
                    
                    <div class="pull-right">                                    <!-- displays the total number of post -->
                        <small>{{ $categoriesCount }} {{ str_plural('Item',$categoriesCount) }}</small>
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


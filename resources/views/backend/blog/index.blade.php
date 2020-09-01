@extends('layouts.backend.main')

<title> MyBlog | BLOG index </title>
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

       @include('backend.blog.statusLabel')        <!-- includes the Labels of the Blog Post according to the publicaton -->

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
                       <a href="{{ route('blog.create') }}" class = "btn btn-success" ><i class="fa fa-plus"></i> Add New</a>
                    </div>

                    <div class="pull-right" style="padding: 7px 0;">
                        <?php $links = [] ?>
                        @foreach ($statusList as $key => $value)     <!-- for displaying all the posts with respect to the numbers -->
                        @if ($value)
                                <?php $selected = Request::get('status') == $key ? 'selected-status' : NULL ?>   <!-- selected-status used for making bold in custom.css -->
                                <?php $links[] = "<a class = \"{$selected}\" href=\"?status={$key}\">"  .ucwords($key) ."({$value}) </a>" ?>
                            @endif
                        @endforeach
                        {!! implode(' | ' ,$links) !!}        <!-- for separating according to the | -->
                    </div>
                </div>
        
              <!-- /.box-header -->
              <div class="box-body ">
                   @include('backend.messages.message')

                    @if ( !$posts->count())
                        <div class="alert alert-danger">
                            <strong>No Record Found </strong>
                        </div>
    
                    @else
                        @if ($onlyTrashed)                          <!-- if TRUE then only displays -->
                            @include('backend.blog.table-trash')
                        @else
                            @include('backend.blog.table-allposts')
                        @endif
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
                        {{ $posts->appends(request()->query())->links() }}      <!-- for pagination and request()->query() is used for requesting data from querystring -->
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


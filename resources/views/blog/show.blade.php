@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post-item post-detail">
                    @if ($posts->imageUrl)    <!-- Displays if there is the image only -->
                        <div class="post-item-image">
                            <a href="#">
                                <img src="{{$posts->imageUrl}}" alt="{{$posts->title}}">
                            </a>
                        </div>
                    @endif
                    <div class="post-item-body">
                        <div class="padding-10">
                            <h1>{{ $posts->title}}</h1>

                            <div class="post-meta no-border">
                                <ul class="post-meta-group">
                                    <li><i class="fa fa-user"></i><a href="#"> {{$posts->author->name}}</a></li>
                                    <li><i class="fa fa-clock-o"></i><time> {{$posts->date}}</time></li>
                                    <li><i class="fa fa-tags"></i><a href="#"> Blog</a></li>
                                    <li><i class="fa fa-comments"></i><a href="#">4 Comments</a></li>
                                </ul>
                            </div>
                            {{ $posts->body }}
                        </div>
                    </div>
                </article>

                <article class="post-author padding-10">
                    <div class="media">
                      <div class="media-left">
                        <a href="#">
                          <img alt="Author 1" src="/img/author.jpg" class="media-object">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading"><a href="#">{{$posts->author->name}}</a></h4>
                        <div class="post-author-count">
                          <a href="#">
                              <i class="fa fa-clone"></i>
                              90 posts
                          </a>
                        </div>
                        {{ $posts->title }}
                      </div>
                    </div>
                </article>

                <!-- comments here -->
                {{-- @include('blog.comments') --}}
            </div>
            @include('layouts.sidebar') 
        </div>
    </div>
@endsection
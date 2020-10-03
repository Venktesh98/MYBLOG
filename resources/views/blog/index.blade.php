@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @if ($posts_send->count() == NULL)
                    <div class="alert alert-warning">
                        <p> Nothing Found </p>
                    </div>
                @else
                    @include('blog.alert')              <!-- includes all the alerts -->
                    
                    @foreach ($posts_send as $post)    <!-- foreach loop for displaying the posts -->                   
                            <article class="post-item">
                                @if ($post->image_url)   <!-- image_url is an alias name of Acessor function -->
                                    <div class="post-item-image">
                                        <a href="{{ route('blog.showblog',$post->slug) }}"> <!-- returns the slug from Post model -->
                                            <img src="{{ $post->image_url }}" alt="">
                                        </a>
                                    </div>
                                @endif
                                <div class="post-item-body">
                                    <div class="padding-10">
                                        <h2><a href="{{ route('blog.showblog',$post->slug) }}">{{$post->title}}</a></h2>
                                        {!! $post->excerpt_html !!}   <!-- called from accessor function from the post model. -->
                                    </div>
                                    
                                    <div class="post-meta padding-10 clearfix">
                                        <div class="pull-left">
                                            <ul class="post-meta-group">
                                                <li><i class="fa fa-user"></i><a href="{{ route('blog.author',$post->author->slug) }}">{{ $post->author->name }}</a></li>
                                                <li><i class="fa fa-clock-o"></i><time> {{ $post->date }}</time></li>
                                                <li><i class="fa fa-folder"></i><a href="{{ route('blog.category',$post->category->slug) }}"> {{ $post->category->title }}</a></li>
                                                <li><i class="fa fa-tag"></i>
                                                    @foreach ($post->tags as $tag) 
                                                        <a href="/tag/{{ $tag->slug }}">{{$loop->first ? '' : ','}}{{ $tag->name }}</a>
                                                    @endforeach  
                                                </li>                                                  
                                                <li><i class="fa fa-comments"></i><a href="{{ route('blog.showblog',$post->slug) }}#post-comments">{{ $post->commentsNumber('Comment') }}</a></li>
                                            </ul>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{ route('blog.showblog',$post->slug) }}">Continue Reading &raquo;</a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                    @endforeach
                @endif
                    <div class="text-right">
                        <ul class="pagination">
                            <nav>
                                {{$posts_send->appends(request()->only(['term','month','year'])) }}   <!-- for pagination and also for getting year and month from querystring -->
                            </nav>
                        </ul>
                    </div>
                    <br>
            </div>  
                @include('layouts.sidebar')
        </div>
    </div>
@endsection
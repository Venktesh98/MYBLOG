@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post-item post-detail">
                    @if ($posts->image_url)    <!-- Displays if there is the image only -->
                        <div class="post-item-image">
                            <a href="#">
                                <img src="{{$posts->image_url}}" alt="{{$posts->title}}">
                            </a>
                        </div>
                    @endif
                    <div class="post-item-body"> 
                        <div class="padding-10">
                            <h1>{{ $posts->title}}</h1>

                            <div class="post-meta no-border">
                                <ul class="post-meta-group">
                                    <li><i class="fa fa-user"></i><a href="{{ route('blog.author',$posts->author->slug) }}" style="color:blueviolet"> <strong> {{$posts->author->name}} </strong> </a></li>
                                    <li><i class="fa fa-clock-o"></i><time> {{$posts->date}}</time></li>
                                    <li><i class="fa fa-folder"></i><a href="{{ route('blog.category',$posts->category->slug) }}"> {{$posts->category->title }}</a></li>
                                    <li><i class="fa fa-tag"></i>
                                        @foreach ($posts->tags as $tag) 
                                            <a href="/tag/{{ $tag->slug }}">{{$loop->first ? '' : ', '}}{{ $tag->name }}</a>
                                        @endforeach
                                    </li> 
                                    <li><i class="fa fa-comments"></i><a href="#post-comments"> {{ $posts->commentsNumber('Comment') }}</a></li>
                                </ul>
                            </div>
                                {!! $posts->body_html !!}  <!-- Accessor function i.e body_html - from post model -->
                            {{-- {{ $posts->body }} --}}
                        </div>
                    </div>
                </article>

                <article class="post-author padding-10">
                    <div class="media">
                        <?php $author = $posts->author; ?> <!-- defining a variable --> 
                            <div class="media-left">
                                <a href="{{ route('blog.author',$author->slug) }}">  <!-- gets the author image here -->
                                <img alt="{{ $author->name }}" width="100" height= "100" src="{{ $author->gravatar() }}" class="media-object">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="{{ route('blog.author',$author->slug) }}">{{$author->name}}</a></h4>
                                <div class="post-author-count">
                                    <a href="{{ route('blog.author',$author->slug) }}">
                                        <i class="fa fa-clone"></i>
                                        <?php $postCount = $author->posts->count() ?> <!-- defining a variable of postCount -->
                                        {{ $postCount }} {{ str_plural('post',$postCount) }} <!-- helper function for plural -->
                                    </a>
                                </div>                        
                                {!! $author->bio_html !!} <!-- In Markdown Format -->
                            </div>
                    </div>
                </article>

                <!-- comments here -->
                @include('blog.comments')
                <br><br>
            </div>
            @include('layouts.sidebar') 
        </div>
    </div>
@endsection
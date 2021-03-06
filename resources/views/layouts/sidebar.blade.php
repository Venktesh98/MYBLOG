<div class="col-md-4">
    <aside class="right-sidebar">
        <div class="search-widget">
            <form action="{{ route('blog') }}" method='GET'>
                <div class="input-group">
                    <input type="text" class="form-control input-lg" value ="{{ request('term') }}" name="term" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-lg btn-default" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                </div><!-- /input-group -->
            </form>
        </div>

        <div class="widget">
            <div class="widget-heading">
                <h4>Categories</h4>
            </div>
            <div class="widget-body">
                <ul class="categories">
                    @foreach ($categories as $category) <!-- categories is coming from the providers.composerServiceProvider file -->
                        <li>
                            <a href="{{ route('blog.category',$category->slug) }}"><i class="fa fa-angle-right"></i> {{$category->title}}</a>
                            <span class="badge pull-right">{{$category->posts->count()}}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="widget">
            <div class="widget-heading">
                <h4>Popular Posts</h4>
            </div>
            <div class="widget-body">
                <ul class="popular-posts">
                    @foreach ($popularposts as $post)
                        <li>
                            @if ($post->image_thumb_url)     <!-- image_thumb_url is a Accessor function from Post model -->
                                <div class="post-image">
                                    <a href="{{ route('blog.showblog',$post->slug) }}">
                                        <img src="{{ $post->image_thumb_url }}" />    <!-- image_thumb_url is a Accessor function Post model-->
                                    </a>
                                </div>
                            @endif
                            <div class="post-body">
                                <h6><a href="{{ route('blog.showblog',$post->slug) }}">{{ $post->title}}</a></h6>
                                <div class="post-meta">
                                    <span>{{ $post->date }}</span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="widget">
            <div class="widget-heading">
                <h4>Tags</h4>
            </div>
            <div class="widget-body">
                <ul class="tags">
                    @foreach ($tags as $tag)
                        <li><a href="/tag/{{$tag->slug}}">{{ $tag->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="widget">
            <div class="widget-heading">
                <h4>Archives</h4>
            </div>
            <div class="widget-body">
                <ul class="categories">
                    @foreach ($archives as $archive)                       
                        <li>
                            {{-- <a href="{{ route('blog',['month' => $archive->month,'year' => $archive->year]) }}">{{ $archive->month." ".$archive->year }}</a> --}}
                            <a href="{{ route('blog',['month' => $archive->month,'year' => $archive->year]) }}">{{ month_name($archive->month)." ".$archive->year }}</a>  <!-- for postgres sql -->
                            <span class="badge pull-right">{{ $archive->post_count }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <br>
    </aside>
</div>
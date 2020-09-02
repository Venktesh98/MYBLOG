<article class="post-comments" id="post-comments">    <!-- for showing up the comments only when click on it -->
    <h3><i class="fa fa-comments"></i> {{ $posts->commentsNumber('Comment') }} </h3>   <!-- comes from Post model -->

    <div class="comment-body padding-10">
        <ul class="comments-list">
            @foreach ($postComments as $comment)     <!-- comments is a function accessed from the Post model as we made the felationship -->
                <li class="comment-item">
                    <div class="comment-heading clearfix">
                        <div class="comment-author-meta">
                            <h4>{{ $comment->author_name }}<small> {{ $comment->date }}</small></h4>
                        </div>
                    </div>
                    <div class="comment-content">
                        {!! $comment->body_html !!}     <!-- Accessor function from Comment model -->
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="text-right">
            <nav>
                {{ $postComments->links() }}
            </nav>
        </div>

    </div>

    {{-- @if(session('message'))      <!-- creation of successfully of the comment -->
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif --}}

    @include('backend.messages.message')

    <div class="comment-footer padding-10">
        <h3>Leave a comment</h3>
        {!! Form::open(['route' => ['blog.comments',$posts->slug ]]) !!}

            <div class="form-group required">
                <label for="name">Name</label>
                {!! Form::text('author_name',null,['class' => 'form-control']) !!}        
            </div>

            <div class="form-group required">
                <label for="email">Email</label>
                {!! Form::text('author_email',null,['class' => 'form-control']) !!}          
            </div>

            <div class="form-group required">
                <label for="website">Website</label>
                {!! Form::text('author_url',null,['class' => 'form-control']) !!}
            </div>

            <div class="form-group required">
                <label for="comment">Comment</label>
                {!! Form::textarea('body',null,['row' => 6 ,'class' => 'form-control']) !!}
            </div>

            <div class="clearfix">
                <div class="pull-left">
                    <button type="submit" class="btn btn-lg btn-success">Submit</button>
                </div>

                <div class="pull-right">
                    <p class="text-muted">
                        <span class="required">*</span>
                        <em>Indicates required fields</em>
                    </p>
                </div>
            </div>
        {!! Form::close() !!}
    </div>

</article>
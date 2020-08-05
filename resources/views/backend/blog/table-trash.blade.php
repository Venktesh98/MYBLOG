<table class="table table-bordered">
    <thead>
        <tr>
            <td width="80">Action</td>
            <td>Title</td>
            <td width = "100">Author</td>
            <td width = "160">Category</td>
            <td width = "180">Date</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post)
            <tr>
                <td>
                    {{-- For restoring the posts from trash --}}
                    {!! Form::open(['style' => 'display:inline-block;' ,'method' => 'PUT','route' => ['backend.blog.restore',$post->id ]]) !!}
                        <button title = "Restore" type="submit" class="btn btn-xs btn-primary">
                            <i class="fa fa-refresh"></i>
                        </button>
                    {!! Form::close() !!}
                    
                    {{-- for deleting the posts permanently from Trash --}}
                    {!! Form::open(['style' => 'display:inline-block;',     'method' => 'delete','route' => ['backend.blog.force-destroy',$post->id ]]) !!}
                        <button title = "Delete Permanently" onclick= "return confirm('You are about to delete post permanently. Are you sure?')" type="submit" class="btn btn-xs btn-danger">                                        
                            <i class="fa fa-times"></i>
                        </button>
                    {!! Form::close() !!}
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
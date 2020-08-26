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
        <?php $request = request() ?>    <!-- request varaible -->
         
        @foreach ($posts as $post)
            <tr>
                <td>
                    {!! Form::open(['method' => 'delete','route' => ['blog.destroy',$post->id ]]) !!}  {{-- Puts the posts into the Trash --}}
                        
                        @if (check_user_permissions($request,'Blog@edit',$post->id))
                            <a href="{{ route('blog.edit',$post->id) }}" class="btn btn-xs btn-primary">  <!-- edits the post -->
                                <i class="fa fa-edit"></i>
                            </a> 
                        
                        @else
                            <a class="btn btn-xs btn-primary disabled">  <!-- disables the edit button -->
                                <i class="fa fa-edit"></i>
                            </a>
                        @endif
                        
                        @if (check_user_permissions($request,'Blog@destroy',$post->id))
                            <button type="submit" class="btn btn-xs btn-danger">                                        
                                <i class="fa fa-trash"></i>
                            </button>
                            
                        @else
                            <button type="button" onclick="return false;" class="btn btn-xs btn-danger disabled">  <!-- disables the delete button -->                                    
                                <i class="fa fa-trash"></i>
                            </button>
                        @endif

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
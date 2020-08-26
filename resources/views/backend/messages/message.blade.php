@if (session('message'))
    <div class="alert alert-success" role="alert">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@elseif (session('error-message'))
<div class="alert alert-danger" role="alert">
    {{ session('error-message') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

@elseif (session('error-message-loginuser'))
<div class="alert alert-danger" role="alert">
    {{ session('error-message-loginuser') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

@elseif(session('trash-message'))
    <?php list($message,$postId) = session('trash-message') ?>
    {!! Form::open(['method'=>'PUT', 'route'=>['backend.blog.restore',$postId]]) !!}
        <div class="alert alert-info" role="alert">
            {{ $message }}
            <button type="button" class="close" style="padding-top:5px" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <button type="submit" class = "btn btn-sm btn-warning"><i class = "fa fa-undo"></i> Undo</button>
        </div>
    {!! Form::close() !!}

@elseif (session('message-temp'))
    <div class="alert alert-danger" role="alert">
        {{ session('message-temp') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<?php $statusLabel = Request::get('status') ?>

@if ($statusLabel == 'own')
    <h1>
        Blogs
        <small> <strong> Own Blog Posts </strong> </small>
    </h1>

@elseif ($statusLabel == 'all')
    <h1>
        Blogs
        <small> <strong> All Blog Posts </strong> </small>
    </h1>

@elseif ($statusLabel == 'published')
    <h1>
        Blogs
        <small> <strong> Published Blog Posts </strong> </small>
    </h1>

@elseif ($statusLabel == 'scheduled')
    <h1>
        Blogs
        <small> <strong> Scheduled Blog Posts </strong> </small>
    </h1>

@elseif ($statusLabel == 'draft')
    <h1>
        Blogs
        <small> <strong> Draft Blog Posts </strong> </small>
    </h1>

@else
    <h1>
        Blogs
        <small> <strong> Trashed Blog Posts </strong> </small>
    </h1>
@endif
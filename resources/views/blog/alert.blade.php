@if($categoryName)     <!-- Category Name -->
    <div class="alert alert-info">
        <p> Category : <strong> {{ $categoryName }} </strong> </p>
    </div>
@endif

@if($tagName)     <!-- Tag Name -->
    <div class="alert alert-info">
        <p> Tagged : <strong> {{ $tagName }} </strong> </p>
    </div>
@endif

@if($authorName)     <!-- Author Name -->
    <div class="alert alert-info">
    <p> Author : <strong> {{ $authorName }} </strong> </p>
    </div>
@endif

@if($term = request('term'))     <!-- Search Name -->
    <div class="alert alert-info">
    <p> Search Results for : <strong> {{ $term }} </strong> </p>
    </div>
@endif